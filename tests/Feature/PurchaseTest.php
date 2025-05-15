<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('initializes the basket with product catalog, delivery rules, and offers via API', function () {
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

    $response = $this->postJson(route('basket.init'), $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data',
            'errors',
            'statusCode'
        ])
        ->assertJson([
            'status' => 'success',
            'message' => 'Basket initialized successfully',
            'data' => [],
            'errors' => null,
            'statusCode' => 200
        ]);
});

it('returns validation errors when initialization data is invalid', function () {
    $invalidData = [
        'products' => [
            ['code' => '', 'name' => 'Red Widget', 'price' => 32.95],
            ['code' => 'G01', 'name' => '', 'price' => 24.95],
            ['code' => 'B01', 'name' => 'Blue Widget', 'price' => null],
        ],
        'delivery_rules' => 'invalid',
        'offers' => null,
    ];

    $response = $this->postJson(route('basket.init'), $invalidData);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'status',
            'message',
            'data',
            'errors',
            'statusCode'
        ])
        ->assertJson([
            'status' => 'error',
            'message' => 'Validation failed',
            'data' => null,
            'statusCode' => 422
        ])
        ->assertJsonFragment([
            'errors' => [
                'products.0.code' => ['The products.0.code field is required.'],
                'products.1.name' => ['The products.1.name field is required.'],
                'products.2.price' => ['The products.2.price field is required.'],
                'delivery_rules' => ['The delivery rules field must be an array.'],
                'offers' => ['The offers field is required.'],
            ]
        ]);
});

it('adds a product to the basket by product code via API')->todo();

it('calculates the total cost of the basket without any offers via API')->todo();

it('applies the "buy one red widget, get the second half price" offer via API')->todo();

it('calculates the total cost with delivery charges applied via API')->todo();

it('calculates the total cost with free delivery via API')->todo();
