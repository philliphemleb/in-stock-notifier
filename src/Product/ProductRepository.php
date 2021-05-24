<?php
declare(strict_types=1);

namespace App\Product;


class ProductRepository
{
    /**
     * @return Product[]
     */
    public function all(): iterable
    {
        yield new Product('Playstation 5 Digital Edition', new Asin('B08H98GVK8'));
        yield new Product('Playstation 5 Disk Edition', new Asin('B08H93ZRK9'));

        yield new Product('Xbox Series X Standard', new Asin('B08H93ZRLL'));
        yield new Product('Xbox Series X + Play & Charge Kit', new Asin('B08PTC8DNZ'));
        yield new Product('Xbox Series X + Headset', new Asin('B08X4BHFSK'));
        yield new Product('Xbox Series X + Elite Controller', new Asin('B08PT9X86M'));
        yield new Product('Xbox Series X + Controller White', new Asin('B08LNV4S61'));
        yield new Product('Xbox Series X + Controller Red', new Asin('B08TNWKXC6'));
        yield new Product('Xbox Series X + Controller Blue', new Asin('B08LNW156Z'));
        yield new Product('Xbox Series X + Controller Black', new Asin('B08LNTDL5S'));
    }
}