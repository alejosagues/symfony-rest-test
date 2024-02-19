<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 64)]
    private string $code;

    #[ORM\Column]
    #[Assert\Regex('/^(?:100(?:\.0{1,2})?|\d{1,2}(?:\.\d{1,2})?)$/')]
    private float $percentage;

    #[ORM\Column]
    private DateTime $createdAt;

    #[ORM\Column]
    private DateTime $expiresAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Coupon
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Coupon
    {
        $this->code = $code;
        return $this;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): Coupon
    {
        $this->percentage = $percentage;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Coupon
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getExpiresAt(): ?DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTime $expiresAt): Coupon
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }
}
