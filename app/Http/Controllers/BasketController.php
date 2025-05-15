<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\InitializeBasketRequest;
use App\Models\Product;
use App\Services\BasketService;

class BasketController extends Controller
{
    use ApiResponse;

    protected $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function init(InitializeBasketRequest $request)
    {
        $this->basketService->initialize(
            $request->input('products'),
            $request->input('delivery_rules'),
            $request->input('offers')
        );

        return $this->successResponse('Basket initialized successfully');
    }

}
