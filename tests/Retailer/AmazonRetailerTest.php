<?php
declare(strict_types=1);

namespace App\Tests\Retailer;

use App\Product\Amazon\AmazonIdentifier;
use App\Product\Amazon\AmazonProduct;
use App\Retailer\AmazonRetailer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class AmazonRetailerTest extends TestCase
{
	public function testIsInStockReturnsFalseIfAddToCartButtonIsMissing()
	{
		$client = new MockHttpClient([
			new MockResponse(file_get_contents(__DIR__.'/../resources/Retailer/amazon_ps5_buybox_out_of_stock.html'))
		]);
		$amazonRetailer = new AmazonRetailer($client);
		$product = new AmazonProduct('Playstation 5', new AmazonIdentifier('B08H93ZRK9'));

		$isInStock = $amazonRetailer->checkStock($product);

		$this->assertFalse($isInStock->isInStock());
		$this->assertSame(1, $client->getRequestsCount());
	}

	public function testIsInStockReturnsTrueIfAddToCartButtonExists()
	{
		$client = new MockHttpClient([
			new MockResponse(file_get_contents(__DIR__.'/../resources/Retailer/amazon_xboxseriess_buybox_in_stock.html'))
		]);
		$amazonRetailer = new AmazonRetailer($client);
		$product = new AmazonProduct('xBox Series S', new AmazonIdentifier('B087VM5XC6'));

		$isInStock = $amazonRetailer->checkStock($product);

		$this->assertTrue($isInStock->isInStock());
		$this->assertSame(1, $client->getRequestsCount());
	}
}
