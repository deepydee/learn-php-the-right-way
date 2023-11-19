<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;



class CollectionController
{
    public function index()
    {
        $filePath =  __DIR__ . '/../../storage/json/products.json';

        $productsJson = json_decode(file_get_contents($filePath), true);

        $products = collect($productsJson['products']);

        $totalCost = 0;

        foreach ($products as $product) {
            $productType = $product['product_type'];

            if ($productType === 'Lamp' || $productType === 'Wallet') {
                foreach ($product['variants'] as $productVariant) {
                    $totalCost += $productVariant['price'];
                }
            }
        }

        echo $totalCost;
    }
}
