<?php
declare(strict_types=1);

namespace App\Product;


class Asin
{
    public function __construct(
        private string $asin
    ) {}

    public function __toString(): string
    {
        return $this->asin;
    }

}