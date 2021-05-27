<?php
declare(strict_types=1);

namespace App\Product\Amazon;


use App\Product\IdentifierInterface;

class AmazonIdentifier implements IdentifierInterface
{
    public function __construct(
        private string $asin
    ) {}

    public function __toString(): string
    {
        return $this->asin;
    }

}