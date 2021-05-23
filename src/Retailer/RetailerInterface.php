<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;

interface RetailerInterface
{
    public function isInStock(Product $product): bool;
}