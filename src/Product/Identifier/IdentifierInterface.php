<?php
declare(strict_types=1);

namespace App\Product\Identifier;


interface IdentifierInterface
{
	public  function __toString(): string;
}