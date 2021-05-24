<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AmazonRetailer implements RetailerInterface
{
	public function __construct(
		private HttpClientInterface $client
	) { }

	public function identifier(): string
	{
		return 'Amazon';
	}

	public function checkStock(Product $product): StockCheckResult
	{
		$shopUrl = 'https://www.amazon.de/dp/' . $product->getAsin();

		$response = $this->client->request(
			'GET',
			$shopUrl,
			[
				'headers' => [
					'dnt' => '1',
					'upgrade-insecure-requests' => '1',
					'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0',
					'referer' => 'https://www.amazon.com/',
					'accept-language' => 'de-DE,de;q=0.9',
					'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36'
				],
			]
		);

		$inStock = str_contains($response->getContent(), 'id="add-to-cart-button"');
		return new StockCheckResult($inStock, $this, $shopUrl);
	}
}