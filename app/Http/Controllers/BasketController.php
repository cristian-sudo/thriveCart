<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\InitializeBasketRequest;
use App\Services\BasketService;

class BasketController extends Controller
{
    use ApiResponse;

    protected BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function init(InitializeBasketRequest $request): JsonResponse
    {
        $products = (array) $request->input('products');
        $deliveryRules = (array) $request->input('delivery_rules');
        $offers = (array) $request->input('offers');

        $this->basketService->initialize($products, $deliveryRules, $offers);

        return $this->successResponse('Basket initialized successfully');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|exists:products,code',
        ]);

        /** @var string $code */
        $code = $request->input('code');

        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if ($user !== null) {
            $userId = (int) $user->id; // Now PHPStan knows $user is not mixed
            $this->basketService->addProduct($userId, $code);
            return $this->successResponse('Product added to basket successfully');
        }

        return $this->errorResponse('User not authenticated', 401);
    }

    public function total(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $offerCode = $request->query('offer_code');

        $total = $this->basketService->getTotal($userId, $offerCode);

        return $this->successResponse('Total calculated successfully', ['total' => $total]);
    }

}
