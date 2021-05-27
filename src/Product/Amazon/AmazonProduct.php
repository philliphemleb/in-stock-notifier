<?php
declare(strict_types=1);

namespace App\Product\Amazon;

use App\Product\ProductInterface;

class AmazonProduct implements ProductInterface
{
    public function __construct(
        private string $name,
        private AmazonIdentifier $asin
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAsin(): AmazonIdentifier
    {
        return $this->asin;
    }
}