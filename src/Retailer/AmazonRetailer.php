<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Component\Panther\Client;

class AmazonRetailer implements RetailerInterface
{
    use TakesScreenshot;

	public function identifier(): string
	{
		return 'Amazon';
	}

	public function checkStock(Client $client, Product $product): StockCheckResult
	{
		if ($product->getAsin() === null) { return new StockCheckResult(false, $this, 'https://www.amazon.de/dp/'); }

		$shopUrl = 'https://www.amazon.de/dp/' . $product->getAsin();
		$crawler = $client->request('GET', $shopUrl);
		$inStockCheck = str_contains($crawler->html(), 'id="add-to-cart-button"');

		$this->takeScreenshot($client, $product);

		return new StockCheckResult($inStockCheck, $this, $shopUrl);
	}
}