<?php

namespace App\Service;

use App\Entity\PurchaseRequest;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{
    private $paypalProcessor;
    private $stripeProcessor;

    public function __construct()
    {
        $this->paypalProcessor = new PaypalPaymentProcessor;
        $this->stripeProcessor = new StripePaymentProcessor;
    }

    public function processPayment(PurchaseRequest $request): bool
    {
        if ($request->getPaymentProcessor() == "paypal") {
            $this->paypalProcessor->pay(intval($request->getFinalPrice() * 100));
        } elseif ($request->getPaymentProcessor() == "stripe") {
            $this->stripeProcessor->processPayment($request->getFinalPrice());
        } else {
            throw new \InvalidArgumentException('Invalid payment processor.');
        }

        return true;
    }
}
