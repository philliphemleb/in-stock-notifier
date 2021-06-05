<?php
declare(strict_types=1);

namespace App\Product;


use App\Product\Identifier\Asin;
use App\Product\Identifier\MediamarktId;

class Product
{
    public function __construct(
        private string $name,
        private ?Asin $asin = null,
	    private ?MediamarktId $mediamarktId = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAsin(): ?Asin
    {
        return $this->asin;
    }

    public function getMediamarktId(): ?MediamarktId
    {
    	return $this->mediamarktId;
    }
}