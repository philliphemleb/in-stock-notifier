<?php
declare(strict_types=1);

namespace App\Product\Amazon;

use App\Product\IdentifierInterface;
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

    public function getIdentifier(): IdentifierInterface
    {
        return $this->asin;
    }
}