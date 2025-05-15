<?php

namespace App\Interfaces;

use App\Models\Basket;
use App\Models\Product;
interface OfferInterface
{
    public function apply(Basket $basket, Product $product, int $quantity, float $price): float;
}
