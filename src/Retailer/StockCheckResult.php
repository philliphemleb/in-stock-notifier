<?php
declare(strict_types=1);

namespace App\Retailer;


class StockCheckResult
{
	public function __construct(
		private bool $inStock,
		private RetailerInterface $retailer,
		private string $shopUrl
	) { }

	/**
	 * @return bool
	 */
	public function isInStock(): bool
	{
		return $this->inStock;
	}

	/**
	 * @return RetailerInterface
	 */
	public function getRetailer(): RetailerInterface
	{
		return $this->retailer;
	}

	/**
	 * @return string
	 */
	public function getShopUrl(): string
	{
		return $this->shopUrl;
	}
}