<?php
declare(strict_types=1);

namespace App\Product;

class Product
{
    public function __construct(
        private string $name,
        private Asin $asin
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAsin(): Asin
    {
        return $this->asin;
    }
}