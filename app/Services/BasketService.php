<?php

namespace App\Services;

use App\Interfaces\BasketServiceInterface;
use App\Models\DeliveryRule;
use App\Models\Offer;
use App\Models\Product;

class BasketService implements BasketServiceInterface
{
    public function initialize(array $catalog, array $deliveryRules, array $offers): void
    {
        Product::truncate();
        foreach ($catalog as $productData) {
            Product::create($productData);
        }

        DeliveryRule::truncate();
        foreach ($deliveryRules as $rule) {
            DeliveryRule::create($rule);
        }

        Offer::truncate();
        foreach ($offers as $type => $productCode) {
            Offer::create([
                'type' => $type,
                'product_code' => $productCode,
            ]);
        }
    }

    public function addProduct(string $code): void
    {

    }

    public function getTotal(): float
    {

    }
}
