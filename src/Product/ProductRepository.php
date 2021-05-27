<?php
declare(strict_types=1);

namespace App\Product;


use App\Product\Amazon\AmazonIdentifier;
use App\Product\Amazon\AmazonProduct;
use App\Product\Mediamarkt\MediamarktIdentifier;
use App\Product\Mediamarkt\MediamarktProduct;

class ProductRepository
{
    /**
     * @return ProductInterface[]
     */
    public function all(): iterable
    {
    	yield new MediamarktProduct('Playstation 5 Disk Edition', new MediamarktIdentifier('_sony-playstation®5-2661938.html'));

        yield new AmazonProduct('Playstation 5 Digital Edition', new AmazonIdentifier('B08H98GVK8'));
        yield new AmazonProduct('Playstation 5 Disk Edition', new AmazonIdentifier('B08H93ZRK9'));

        yield new AmazonProduct('Xbox Series X Standard', new AmazonIdentifier('B08H93ZRLL'));
        yield new AmazonProduct('Xbox Series X + Play & Charge Kit', new AmazonIdentifier('B08PTC8DNZ'));
        yield new AmazonProduct('Xbox Series X + Headset', new AmazonIdentifier('B08X4BHFSK'));
        yield new AmazonProduct('Xbox Series X + Elite Controller', new AmazonIdentifier('B08PT9X86M'));
        yield new AmazonProduct('Xbox Series X + Controller White', new AmazonIdentifier('B08LNV4S61'));
        yield new AmazonProduct('Xbox Series X + Controller Red', new AmazonIdentifier('B08TNWKXC6'));
        yield new AmazonProduct('Xbox Series X + Controller Blue', new AmazonIdentifier('B08LNW156Z'));
        yield new AmazonProduct('Xbox Series X + Controller Black', new AmazonIdentifier('B08LNTDL5S'));
    }
}