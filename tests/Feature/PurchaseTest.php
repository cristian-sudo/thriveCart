<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;

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

    foreach ($data['products'] as $product) {
        $this->assertDatabaseHas('products', $product);
    }

    foreach ($data['delivery_rules'] as $rule) {
        $this->assertDatabaseHas('delivery_rules', $rule);
    }

    foreach ($data['offers'] as $type => $productCode) {
        $this->assertDatabaseHas('offers', [
            'type' => $type,
            'product_code' => $productCode,
        ]);
    }
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

it('adds a product to the basket by product code via API', function () {
    $this->insertPredefinedBasketData();

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->postJson(route('basket.add'), ['code' => 'R01']);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Product added to basket successfully',
        ]);

    $this->assertDatabaseHas('basket_product', [
        'basket_id' => $user->basket->id,
        'product_id' => Product::where('code', 'R01')->first()->id,
        'quantity' => 1,
    ]);
});

it('calculates the total cost of the basket without any offers via API', function () {
    $this->insertPredefinedBasketData();

    $user = User::factory()->create();

    $this->actingAs($user);

    $this->postJson(route('basket.add'), ['code' => 'R01']);
    $this->postJson(route('basket.add'), ['code' => 'G01']);

    $response = $this->getJson(route('basket.total'));

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Total calculated successfully',
            'data' => [
                'total' => 57.90, // 32.95 + 24.95
            ],
        ]);
});

it('calculates the total cost of the basket with an optional offer code via API', function () {
    $this->insertPredefinedBasketData();

    $user = User::factory()->create();

    $this->actingAs($user);

    $this->postJson(route('basket.add'), ['code' => 'R01']);
    $this->postJson(route('basket.add'), ['code' => 'R01']);

    $offerCode = 'buy_one_get_one_half_price';
    $response = $this->getJson(route('basket.total', ['offer_code' => $offerCode]));

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Total calculated successfully',
            'data' => [
                'total' => 49.43,
            ],
        ]);
});

it('calculates the total cost with delivery charges applied via API')->todo();

it('calculates the total cost with free delivery via API')->todo();
