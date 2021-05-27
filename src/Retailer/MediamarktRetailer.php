<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\ProductInterface;
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

	public function checkStock(ProductInterface $product): StockCheckResult
	{
		$shopUrl = 'https://www.mediamarkt.de/de/product/' . $product->getIdentifier();

		$response = $this->client->request(
			'GET',
			$shopUrl,
			[
				'headers' => [
					'dnt' => '1',
					'upgrade-insecure-requests' => '1',
					'accept' => 'text/html,application/xhtml+xml',
					'referer' => 'https://www.amazon.com/',
					'accept-language' => 'de-DE,de;q=0.9',
					'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36'
				],
			]
		);

		$inStock = str_contains($response->getContent(), 'data-test="mms-delivery-online-availability"');
		return new StockCheckResult($inStock, $this, $shopUrl);
	}
}