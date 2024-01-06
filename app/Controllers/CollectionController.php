<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;



class CollectionController
{
    public function index()
    {
        $filePath =  __DIR__ . '/../../storage/json/products.json';

        $productsJson = json_decode(file_get_contents($filePath));

        $products = collect($productsJson->products);

        $totalCost = 0;

        $totalCost = $products
            ->filter(fn($product) => collect(['Lamp', 'Wallet'])->contains($product->product_type))
            ->flatMap(fn($product) => $product->variants)
            ->sum('price');

        echo $totalCost;
    }
}
