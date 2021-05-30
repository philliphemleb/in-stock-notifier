<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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

    /**
     * @throws RetailerException
     */
    public function checkStock(Product $product): StockCheckResult
	{
		$shopUrl = 'https://www.amazon.de/dp/' . $product->getAsin();

		try {
            $response = $this->client->request(
                'GET',
                $shopUrl,
                [
                    'headers' => [
                        'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'pragma' => 'no-cache',
                        'Cache-Control' => 'no-cache',
                        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
                        'accept-language' => 'de-DE,de;q=0.9',
                        'Connection' => 'keep-alive',
                        'referer' => 'https://www.amazon.com/',
                    ],
                ]
            );
        } catch (TransportExceptionInterface $e) {
		    throw RetailerException::fromTransportException($e, $this);
        }

        try {
            $inStock = str_contains($response->getContent(), 'id="add-to-cart-button"');
        } catch (HttpExceptionInterface $e) {
		    throw RetailerException::fromHttpException($e, $this);
        } catch (TransportExceptionInterface $e) {
		    throw RetailerException::fromTransportException($e, $this);
        }

        return new StockCheckResult($inStock, $this, $shopUrl);
	}
}