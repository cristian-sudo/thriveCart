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

        $existingProduct = $basket->products()->where('product_id', $product->id)->first();

        if ($existingProduct) {
            $currentQuantity = $existingProduct->pivot->quantity;
            $basket->products()->updateExistingPivot($product->id, ['quantity' => $currentQuantity + 1]);
        } else {
            $basket->products()->attach($product->id, ['quantity' => 1]);
        }
    }

    public function getTotal(int $user_id, ?string $offerCode = null): float
    {
        $basket = Basket::where('user_id', $user_id)->first();

        if (!$basket) {
            return 0.0;
        }

        $total = 0;

        $offer = $offerCode ? Offer::where('type', $offerCode)->first() : null;
        $offerStrategy = $offer ? OfferFactory::create($offer->type) : null;

        foreach ($basket->products as $product) {
            $quantity = $product->pivot->quantity;
            $price = $product->price;

            if ($offerStrategy && $product->code === $offer->product_code) {
                $total += $offerStrategy->apply($basket, $product, $quantity, $price);
            } else {
                $total += $quantity * $price;
            }
        }

        return round($total, 2);
    }
}
