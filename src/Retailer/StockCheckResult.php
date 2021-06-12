<?php
declare(strict_types=1);

namespace App\Retailer;


class StockCheckResult
{
    private ?\SplFileInfo $screenshot = null;

	public function __construct(
		private bool $inStock,
		private RetailerInterface $retailer,
		private string $shopUrl
	) { }

    public function withScreenshot(\SplFileInfo $screenshot): self
    {
        $this->screenshot = $screenshot;
        return $this;
    }

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

	public function getScreenshot(): ?\SplFileInfo
    {
        return $this->screenshot;
    }
}