<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MediamarktRetailer implements RetailerInterface
{
	public function __construct(
		private HttpClientInterface $client
	) { }

	public function identifier(): string
	{
		return 'Mediamarkt';
	}

	public function checkStock(Product $product): StockCheckResult
	{
		if ($product->getMediamarktId() === null) { return new StockCheckResult(false, $this,'https://www.mediamarkt.de/de/product/'); }

		$shopUrl = 'https://www.mediamarkt.de/de/product/' . $product->getMediamarktId();

		$response = $this->client->request('GET', $shopUrl);

		$inStock = str_contains($response->getContent(), 'data-test="mms-delivery-online-availability"');
		return new StockCheckResult($inStock, $this, $shopUrl);
	}
}