<?php
declare(strict_types=1);

namespace App\Crawler\Event;


use App\Product\Product;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\Service\Attribute\Required;

abstract class CrawlerEvent extends Event
{
    public function __construct(
        protected Product $product
    ) {}

    public function getProduct(): Product
    {
        return $this->product;
    }
}