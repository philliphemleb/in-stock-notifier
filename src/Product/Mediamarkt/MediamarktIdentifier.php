<?php
declare(strict_types=1);

namespace App\Product\Mediamarkt;


use App\Product\IdentifierInterface;

class MediamarktIdentifier implements IdentifierInterface
{
    public function __construct(
        private string $id
    ) {}

    public function __toString(): string
    {
        return $this->id;
    }

}