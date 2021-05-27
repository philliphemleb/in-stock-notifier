<?php
declare(strict_types=1);

namespace App\Product;


interface ProductInterface
{
	public function getName(): string;
	public function getIdentifier(): IdentifierInterface;
}