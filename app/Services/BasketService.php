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

    public function addProduct(int $user_id, string $code): void
    {
        $product = Product::where('code', $code)->firstOrFail();

        $basket = Basket::firstOrCreate(['user_id' => $user_id]);

        $basket->products()->syncWithoutDetaching([$product->id => ['quantity' => 1]]);
    }

    public function getTotal(int $user_id): float
    {
        $basket = Basket::where('user_id', $user_id)->first();

        if (!$basket) {
            return 0.0;
        }

        $total = $basket->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        return round($total, 2);
    }
}
