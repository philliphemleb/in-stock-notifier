<?php
declare(strict_types=1);

namespace App\Product;


use App\Product\Identifier\Asin;
use App\Product\Identifier\MediamarktId;

class ProductRepository
{
    /**
     * @return ProductInterface[]
     */
    public function all(): iterable
    {
    	yield new Product('Playstation 5 Digital Edition', new Asin('B08H98GVK8'), new MediamarktId('_sony-playstation®5-digital-edition-2661939.html'));
        yield new Product('Playstation 5 Disk Edition', new Asin('B08H93ZRK9'), new MediamarktId('_sony-playstation®5-2661938.html'));

        yield new Product('Xbox Series X Standard', new Asin('B08H93ZRLL'), new MediamarktId('_microsoft-xbox-series-x-1-tb-2677360.html'));
        yield new Product('Xbox Series X + Play & Charge Kit', new Asin('B08PTC8DNZ'));
        yield new Product('Xbox Series X + Headset', new Asin('B08X4BHFSK'));
        yield new Product('Xbox Series X + Elite Controller', new Asin('B08PT9X86M'));
        yield new Product('Xbox Series X + Controller White', new Asin('B08LNV4S61'));
        yield new Product('Xbox Series X + Controller Red', new Asin('B08TNWKXC6'));
        yield new Product('Xbox Series X + Controller Blue', new Asin('B08LNW156Z'));
        yield new Product('Xbox Series X + Controller Black', new Asin('B08LNTDL5S'));
    }
}