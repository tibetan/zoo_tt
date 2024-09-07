<?php

namespace App\Repository;

use App\Entity\Shipping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository of Shipping
 *
 * @extends ServiceEntityRepository<Shipping>
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingRepository extends ServiceEntityRepository
{
    public function __construct(
        public ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Shipping::class);
    }

    /**
     * Save Shipping to DB
     *
     * @param Shipping $shipping
     */
    public function save(Shipping $shipping): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($shipping);
        $entityManager->flush();
    }

    /**
     * Returns all records sorted by creation date.
     *
     * @return Shipping[]
     */
    public function findAllShippingByCreatedAt(): array
    {
        return $this->findBy([], ['createdAt' => 'DESC']);
    }
}
