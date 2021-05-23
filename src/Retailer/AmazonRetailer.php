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

	public function isInStock(Product $product): bool
	{
		$response = $this->client->request(
			'GET',
			'https://amazon.com/dp/' . $product->getAsin()
		);

		return str_contains($response->getContent(), 'id="add-to-cart-button"');
	}
}