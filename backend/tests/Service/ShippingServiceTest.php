<?php

namespace App\Tests\Service;

use App\Service\ShippingService;
use App\Factory\ShippingFactory;
use App\Repository\ShippingRepository;
use App\Service\Carrier\TransCompany;
use App\Service\Carrier\PackGroup;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Tests of cost calculating from the carriers
 *
 * Class ShippingServiceTest
 * @package App\Tests\Service
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingServiceTest extends TestCase
{
    private ShippingService $shippingService;
    private ShippingFactory $shippingFactory;
    private ShippingRepository $shippingRepository;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialize the dependencies with mocks
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->shippingFactory = $this->createMock(ShippingFactory::class);
        $this->shippingRepository = $this->createMock(ShippingRepository::class); // Initialize the property
        $this->shippingService = new ShippingService($this->shippingFactory, $this->shippingRepository);
    }

    /**
     * Test of cost calculating from TransCompany
     */
    public function testCalculateCostWithTransCompany()
    {
        $carrier = 'trans_company';
        $weight = 12.4;

        $expectedCost = 100.00;

        $transCompanyStrategy = $this->createMock(TransCompany::class);
        $transCompanyStrategy->expects($this->once())
            ->method('calculateCost')
            ->with($weight)
            ->willReturn($expectedCost);

        $this->shippingFactory->expects($this->once())
            ->method('create')
            ->with($carrier)
            ->willReturn($transCompanyStrategy);

        $cost = $this->shippingService->calculate($carrier, $weight);

        $this->assertEquals($expectedCost, $cost);
    }

    /**
     * Test of cost calculating from PackGroup
     */
    public function testCalculateCostWithPackGroup()
    {
        $carrier = 'pack_group';
        $weight = 12.4;

        $expectedCost = 12.4;

        $packGroupStrategy = $this->createMock(PackGroup::class);
        $packGroupStrategy->expects($this->once())
            ->method('calculateCost')
            ->with($weight)
            ->willReturn($expectedCost);

        $this->shippingFactory->expects($this->once())
            ->method('create')
            ->with($carrier)
            ->willReturn($packGroupStrategy);

        $cost = $this->shippingService->calculate($carrier, $weight);

        $this->assertEquals($expectedCost, $cost);
    }
}
