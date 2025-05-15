<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\InitializeBasketRequest;
use App\Models\Product;

class BasketController extends Controller
{
    use ApiResponse;

    public function init(InitializeBasketRequest $request)
    {
        Product::truncate();

        foreach ($request->input('products') as $productData) {
            Product::create($productData);
        }

        return $this->successResponse('Basket initialized successfully');
    }

}
