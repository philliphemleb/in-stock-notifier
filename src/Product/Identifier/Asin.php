<?php
declare(strict_types=1);

namespace App\Product\Identifier;

class Asin implements IdentifierInterface
{
    public function __construct(
        private string $asin
    ) {}

    public function __toString(): string
    {
        return $this->asin;
    }

}