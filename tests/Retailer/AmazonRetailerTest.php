<?php
declare(strict_types=1);

namespace App\Tests\Retailer;

use App\Product\Asin;
use App\Product\Product;
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
		$product = new Product('Playstation 5', new Asin('B08H93ZRK9'));

		$isInStock = $amazonRetailer->checkStock($product);

		$this->assertFalse($isInStock);
		$this->assertSame(1, $client->getRequestsCount());
	}

	public function testIsInStockReturnsTrueIfAddToCartButtonExists()
	{
		$client = new MockHttpClient([
			new MockResponse(file_get_contents(__DIR__.'/../resources/Retailer/amazon_xboxseriess_buybox_in_stock.html'))
		]);
		$amazonRetailer = new AmazonRetailer($client);
		$product = new Product('xBox Series S', new Asin('B087VM5XC6'));

		$isInStock = $amazonRetailer->checkStock($product);

		$this->assertTrue($isInStock);
		$this->assertSame(1, $client->getRequestsCount());
	}
}
