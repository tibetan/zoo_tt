<?php

namespace App\Service\Carrier;

use App\Service\ShippingStrategyInterface;
use App\Util\ClassNameConverter;

/**
 * Class PackGroup
 * @package App\Service\Carrier
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class PackGroup implements ShippingStrategyInterface
{
    public function calculateCost(float $weight): ?float {
        return $weight > 0 ? $weight * 1 : null;
    }

    public function getSlug(): string
    {
        return ClassNameConverter::toSlug(self::class);
    }
}
