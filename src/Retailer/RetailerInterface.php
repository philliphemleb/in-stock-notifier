<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\ProductInterface;

interface RetailerInterface
{
	/**
	 * Returns retailer name. Used for notifications
	 */
	public function identifier(): string;
    public function checkStock(ProductInterface $product): StockCheckResult;
}