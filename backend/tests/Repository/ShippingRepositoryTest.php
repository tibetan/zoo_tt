<?php

namespace App\Tests\Repository;

use App\Entity\Shipping;
use App\Repository\ShippingRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests of DB
 *
 * Class ShippingRepositoryTest
 * @package App\Tests\Repository
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingRepositoryTest extends KernelTestCase
{
    private ShippingRepository $shippingRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->shippingRepository = self::getContainer()->get(ShippingRepository::class);

        $entityManager = $this->shippingRepository->getEntityManager();
        $entityManager->createQuery('DELETE FROM App\Entity\Shipping')->execute();
    }

    /**
     * Test saving data from DB
     */
    public function testSave(): void
    {
        $shipping = new Shipping();
        $shipping->setCarrier('trans_company');
        $shipping->setWeight('12.4');
        $shipping->setPrice('100.00');

        $this->shippingRepository->save($shipping);

        $savedShipping = $this->shippingRepository->findAll();
        $this->assertCount(1, $savedShipping);
        $this->assertEquals('trans_company', $savedShipping[0]->getCarrier());
    }

    /**
     * Test fetching data from DB
     */
    public function testFindAllShippingByCreatedAt(): void
    {
        $shipping1 = new Shipping();
        $shipping1->setCarrier('trans_company');
        $shipping1->setWeight('12.4');
        $shipping1->setPrice('100.00');

        $shipping2 = new Shipping();
        $shipping2->setCarrier('pack_group');
        $shipping2->setWeight('10.0');
        $shipping2->setPrice('50.00');

        $this->shippingRepository->save($shipping1);
        sleep(2);
        $this->shippingRepository->save($shipping2);

        $shippings = $this->shippingRepository->findAllShippingByCreatedAt();

        $this->assertCount(2, $shippings);
        $this->assertEquals('pack_group', $shippings[0]->getCarrier());
        $this->assertEquals('trans_company', $shippings[1]->getCarrier());
    }
}
