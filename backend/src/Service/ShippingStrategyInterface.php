<?php

namespace App\Service;

interface ShippingStrategyInterface {
    public function calculateCost(float $weight): ?float;

    public function getSlug(): string;
}
