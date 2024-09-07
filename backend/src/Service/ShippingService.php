<?php

namespace App\Service;

use App\Factory\ShippingFactory;
use App\Entity\Shipping;
use App\Repository\ShippingRepository;

/**
 * Service of Shipping
 *
 * Class ShippingService
 * @package App\Service
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingService
{
    public function __construct(
        private ShippingFactory $shippingFactory,
        private ShippingRepository $shippingRepository,
    ) {
    }

    /**
     * Calculate cost of the carrier
     *
     * @param string $carrier
     * @param float $weight
     * @return float
     */
    public function calculate(string $carrier, float $weight): float {
        $strategy = $this->shippingFactory->create($carrier);
        return $strategy->calculateCost($weight);
    }

    /**
     * Save Shipping to the DB
     *
     * @param string $carrier
     * @param float $weight
     * @param float $cost
     */
    public function saveShippingData(string $carrier, float $weight, float $cost): void
    {
        $shipping = new Shipping();
        $shipping->setCarrier($carrier);
        $shipping->setWeight($weight);
        $shipping->setPrice($cost);

        $this->shippingRepository->save($shipping);
    }

    /**
     * Get Shippings from the DB
     *
     * @return mixed
    */
    public function getShipping()
    {
        return $this->shippingRepository->findAllShippingByCreatedAt();
    }
}
