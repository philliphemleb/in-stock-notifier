<?php
declare(strict_types=1);

namespace App\Product\Mediamarkt;

use App\Product\ProductInterface;

class MediamarktProduct implements ProductInterface
{
    public function __construct(
        private string $name,
        private MediamarktIdentifier $id
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentifier(): MediamarktIdentifier
    {
        return $this->id;
    }
}