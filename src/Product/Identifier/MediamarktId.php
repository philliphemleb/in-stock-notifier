<?php
declare(strict_types=1);

namespace App\Product\Identifier;

class MediamarktId implements IdentifierInterface
{
    public function __construct(
        private string $mediamarktId
    ) {}

    public function __toString(): string
    {
        return $this->mediamarktId;
    }

}