<?php
declare(strict_types=1);

namespace App\Tests\Retailer;

use App\Product\Mediamarkt\MediamarktIdentifier;
use App\Product\Mediamarkt\MediamarktProduct;
use App\Retailer\MediamarktRetailer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class MediamarktRetailerTest extends TestCase
{
	public function testIsInStockReturnsFalseIfAddToCartButtonIsMissing()
	{
		$client = new MockHttpClient([
			new MockResponse(file_get_contents(__DIR__.'/../resources/Retailer/mediamarkt_ps5_cardstyled_out_of_stock.html'))
		]);
		$mediamarktRetailer = new MediamarktRetailer($client);
		$product = new MediamarktProduct('Playstation 5', new MediamarktIdentifier('_sony-playstation®5-2661938.html'));

		$isInStock = $mediamarktRetailer->checkStock($product);

		$this->assertFalse($isInStock->isInStock());
		$this->assertSame(1, $client->getRequestsCount());
	}

	public function testIsInStockReturnsTrueIfAddToCartButtonExists()
	{
		$client = new MockHttpClient([
			new MockResponse(file_get_contents(__DIR__.'/../resources/Retailer/mediamarkt_xboxseriess_cardstyled_in_stock.html'))
		]);
		$mediamarktRetailer = new MediamarktRetailer($client);
		$product = new MediamarktProduct('Playstation 5', new MediamarktIdentifier('_sony-playstation®5-2661938.html'));

		$isInStock = $mediamarktRetailer->checkStock($product);

		$this->assertTrue($isInStock->isInStock());
		$this->assertSame(1, $client->getRequestsCount());
	}
}
