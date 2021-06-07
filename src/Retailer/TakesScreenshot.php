<?php
declare(strict_types=1);

namespace App\Retailer;


use App\Product\Product;
use Symfony\Component\Panther\Client;

trait TakesScreenshot
{
    private function takeScreenshot(Client $client, Product $product)
    {
        $slugify = static fn(string $text): string => preg_replace('/([-]{2,})/', '-', str_replace([' '], '-', strtolower($text)));
        $filename = tempnam(
            sys_get_temp_dir(),
            $slugify(sprintf('instocknotifier.%s-%s-', $this->identifier(), $product->getName()))
        ) . '.png';
        $client->takeScreenshot($filename);
        if (property_exists($this, 'logger')) {
            $this->logger->info(sprintf('Took a screenshot from %s for %s, saved to %s', $this->identifier(), $product->getName(), $filename));
        }
    }
}