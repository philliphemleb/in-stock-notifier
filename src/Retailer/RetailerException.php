<?php
declare(strict_types=1);

namespace App\Retailer;


use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class RetailerException extends \RuntimeException
{
    private function __construct(private RetailerInterface $retailer, private ?ResponseInterface $response = null, Throwable $previous = null)
    {
        $message = sprintf('Error during communication with retailer: %s', $previous->getMessage());
        parent::__construct(message: $message, previous: $previous);
    }

    public static function fromTransportException(TransportExceptionInterface $exception, RetailerInterface $retailer): static
    {
        return new static(retailer: $retailer, previous: $exception);
    }

    public static function fromHttpException(HttpExceptionInterface $exception, RetailerInterface $retailer): static
    {
        return new static(retailer: $retailer, response: $exception->getResponse(), previous: $exception);
    }

    public function retailer(): RetailerInterface
    {
        return $this->retailer;
    }

    public function response(): ?ResponseInterface
    {
        return $this->response;
    }
}