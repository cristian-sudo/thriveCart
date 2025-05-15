<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\InitializeBasketRequest;
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

    public function add(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:products,code',
        ]);

        $userId = $request->user()->id;

        $this->basketService->addProduct($userId, $request->input('code'));

        return $this->successResponse('Product added to basket successfully');
    }

    public function total(Request $request)
    {
        $userId = auth()->id();
        $offerCode = $request->query('offer_code');

        $total = $this->basketService->getTotal($userId, $offerCode);

        return $this->successResponse('Total calculated successfully', ['total' => $total]);
    }

}
