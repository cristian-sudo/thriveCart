<?php

namespace App\Interfaces;

interface BasketServiceInterface
{
    /**
     * Initialize the service with product catalog, delivery rules, and offers.
     */
    public function initialize(array $catalog, array $deliveryRules, array $offers): void;

    /**
     * Add a product to the basket by product code.
     */
    public function addProduct(int $user_id, string $code): void;

    /**
     * Get the total cost of the basket, including delivery and offers.
     */
    public function getTotal(int $user_id): float;
}
