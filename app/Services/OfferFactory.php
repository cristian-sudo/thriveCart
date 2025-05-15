<?php

namespace App\Services;
use App\Interfaces\OfferInterface;
use App\OfferTypes\BuyOneGetOneHalfPriceOffer;

class OfferFactory
{
    public static function create(?string $offerType): ?OfferInterface
    {
        switch ($offerType) {
            case 'buy_one_get_one_half_price':
                return new BuyOneGetOneHalfPriceOffer();
            default:
                return null;
        }
    }
}
