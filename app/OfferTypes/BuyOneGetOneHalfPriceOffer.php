<?php
namespace App\OfferTypes;
use App\Interfaces\OfferInterface;
use App\Models\Basket;
use App\Models\Product;
/**
 * Buy One Get One Half Price Offer
 *
 * This offer applies a discount where for every two items purchased, the second item is half price.
 */

class BuyOneGetOneHalfPriceOffer implements OfferInterface
{
    public function apply(Basket $basket, Product $product, int $quantity, float $price): float
    {
        if ($quantity > 1) {
            $offerQuantity = intdiv($quantity, 2);
            $regularQuantity = $quantity - $offerQuantity;
            return $regularQuantity * $price + $offerQuantity * ($price / 2);
        }

        return $quantity * $price;
    }
}
