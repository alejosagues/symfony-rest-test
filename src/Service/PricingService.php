<?php

namespace App\Service;

use App\Entity\CalculatePriceRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

class PricingService
{
    private $productRepository;
    private $couponRepository;

    public function __construct(
        ProductRepository $productRepository,
        CouponRepository $couponRepository
    ) {
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * This services should use the connection to the database through repositories and
     * EntityManager to get the corresponding data.
     * Here we are hardcoding the values.
     */

    public function calculatePrice(CalculatePriceRequest $request): void
    {
        $product = $this->productRepository->find($request->getProductId());

        if (isset($product)) {
            $price = $product->getPrice();
        } else {
            throw new \InvalidArgumentException('Invalid product.');
        }

        if (!empty($request->getCouponCode())) {
            $discount = $this->getCouponDiscount($request->getCouponCode());
            $price = round($price * $discount / 100, 2);
        }

        $taxRate = $this->getTaxRateFromTaxNumber($request->getTaxNumber());

        $price = round($price * (1 + $taxRate / 100), 2);

        $request->setFinalPrice($price);
    }

    private function getTaxRateFromTaxNumber(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);
        // Hardcoding tax rates
        $taxRates = [
            'DE' => 19,
            'FR' => 20,
            'GR' => 24,
            'IT' => 22
        ];


        if (isset($taxRates[$countryCode])) {
            return $taxRates[$countryCode];
        } else {
            throw new \InvalidArgumentException('Invalid country code in tax number.');
        }
    }

    private function getCouponDiscount(string $couponCode): float
    {
        $coupon = $this->couponRepository->findOneByCode($couponCode);

        if (isset($coupon)) {
            return 100 - $coupon->getPercentage();
        } else {
            throw new \InvalidArgumentException('Coupon not found.');
        }
    }
}
