<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Component\Panther\Client;

class MediamarktRetailer implements RetailerInterface
{
    use TakesScreenshot;

	public function identifier(): string
	{
		return 'Mediamarkt';
	}

	public function checkStock(Client $client, Product $product): StockCheckResult
	{
		if ($product->getMediamarktId() === null) { return new StockCheckResult(false, $this,'https://www.mediamarkt.de/de/product/'); }

		$shopUrl = 'https://www.mediamarkt.de/de/product/' . $product->getMediamarktId();
		$crawler = $client->request('GET', $shopUrl);
		$inStockCheck = str_contains($crawler->html(), 'data-test="mms-delivery-online-availability"');

		$this->takeScreenshot($client, $product);

		return new StockCheckResult($inStockCheck, $this, $shopUrl);
	}
}