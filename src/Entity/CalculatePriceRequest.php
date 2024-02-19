<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest
{
    private int $id;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $productId;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(DE|IT|GR|FR[A-Z]{2})\d+$/',
        message: 'Tax number is invalid'
    )]
    private string $taxNumber;

    private ?string $couponCode = null;

    private float $finalPrice;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): CalculatePriceRequest {
        $this->id = $id;
        return $this;
    }

    public function getProductId(): int {
        return $this->productId;
    }

    public function setProductId(int $productId): CalculatePriceRequest {
        $this->productId = $productId;
        return $this;
    }

    public function getTaxNumber(): string {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): CalculatePriceRequest {
        $this->taxNumber = $taxNumber;
        return $this;
    }

    public function getCouponCode(): ?string {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): CalculatePriceRequest {
        $this->couponCode = $couponCode;
        return $this;
    }

    public function getFinalPrice(): ?float {
        return $this->finalPrice;
    }

    public function setFinalPrice(?float $finalPrice): CalculatePriceRequest {
        $this->finalPrice = $finalPrice;
        return $this;
    }
}
