<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends CalculatePriceRequest
{

    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: ['paypal', 'stripe'],
        message: 'Select a valid payment processor.'
    )]
    private string $paymentProcessor;

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): PurchaseRequest
    {
        $this->paymentProcessor = $paymentProcessor;
        return $this;
    }
}
