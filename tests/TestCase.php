<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Product;
use App\Models\DeliveryRule;
use App\Models\Offer;

abstract class TestCase extends BaseTestCase
{
    public function insertPredefinedBasketData()
    {
        $data = [
            'products' => [
                ['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95],
                ['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95],
                ['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95],
            ],
            'delivery_rules' => [
                ['threshold' => 50, 'cost' => 4.95],
                ['threshold' => 90, 'cost' => 2.95],
                ['threshold' => 100, 'cost' => 0.00],
            ],
            'offers' => [
                'buy_one_get_one_half_price' => 'R01'
            ]
        ];

        foreach ($data['products'] as $product) {
            Product::create($product);
        }

        foreach ($data['delivery_rules'] as $rule) {
            DeliveryRule::create($rule);
        }

        foreach ($data['offers'] as $type => $productCode) {
            Offer::create([
                'type' => $type,
                'product_code' => $productCode,
            ]);
        }
    }
}
