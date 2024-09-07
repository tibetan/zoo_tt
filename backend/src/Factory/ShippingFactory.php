<?php

namespace App\Factory;

use App\Service\Carrier\TransCompany;
use App\Service\Carrier\PackGroup;
use App\Service\ShippingStrategyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Factory of Shipping
 *
 * Class ShippingFactory
 * @package App\Factory
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingFactory
{
    public function __construct(
        private ContainerInterface $container,
        private LoggerInterface $logger,
    ) {
    }

    public function create(string $carrier): ShippingStrategyInterface
    {
        $this->logger->info("Creating strategy for carrier: " . $carrier);

        foreach ($this->container->getServiceIds() as $serviceId) {
            $service = $this->container->get($serviceId);
            if ($service instanceof ShippingStrategyInterface && $service->getSlug() === $carrier) {
                return $service;
            }
        }

        throw new \Exception("Unknown carrier: $carrier");
    }
}
