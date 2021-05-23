<?php
declare(strict_types=1);

namespace App\Notifier;


use App\Product\Product;

interface NotifierInterface
{
	public function send(Product $product): void;
}