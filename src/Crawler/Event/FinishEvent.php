<?php
declare(strict_types=1);

namespace App\Crawler\Event;


use App\Product\Product;
use App\Retailer\StockCheckResult;

class FinishEvent extends CrawlerEvent
{
    private array $stockCheckResults;

    public function __construct(Product $product, StockCheckResult ...$stockCheckResults)
    {
        parent::__construct($product);
        $this->stockCheckResults = $stockCheckResults;
    }

    public function getStockCheckResults(): array
    {
        return $this->stockCheckResults;
    }
}