<?php

namespace App\Entity;

use App\Repository\ShippingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShippingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Shipping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carrier = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrier(): ?string
    {
        return $this->carrier;
    }

    public function setCarrier(?string $carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price)
    {
        $this->price = $price;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->setUpdatedAtValue();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
