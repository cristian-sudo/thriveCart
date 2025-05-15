<?php

namespace App\Services;

use App\Interfaces\BasketServiceInterface;
use App\Models\DeliveryRule;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Basket;

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

    public function addProduct(int $userId, string $code): void
    {
        $product = Product::where('code', $code)->firstOrFail();

        $basket = Basket::firstOrCreate(['user_id' => $userId]);

        $basket->products()->syncWithoutDetaching([$product->id => ['quantity' => 1]]);
    }

    public function getTotal(): float
    {

    }
}
