<?php

namespace App\Service\Carrier;

use App\Service\ShippingStrategyInterface;
use App\Util\ClassNameConverter;

/**
 * Class TransCompany
 * @package App\Service\Carrier
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class TransCompany implements ShippingStrategyInterface
{
    public function calculateCost(float $weight): ?float {
        $cost = match (true) {
            $weight < 0 => null,
            ($weight > 0) && ($weight <= 10) => 20,
            $weight > 10 => 100
        };

        return $cost;
    }

    public function getSlug(): string
    {
        return ClassNameConverter::toSlug(self::class);
    }
}
