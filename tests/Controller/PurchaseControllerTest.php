<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    const PURCHASE_ENDPOINT = '/purchase';

    public function testPaypalPurchaseEndpoint()
    {
        $client = static::createClient();

        $client->request('POST', self::PURCHASE_ENDPOINT, [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10',
            'paymentProcessor' => 'paypal'
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testStripePurchaseEndpoint()
    {
        $client = static::createClient();

        $client->request('POST', self::PURCHASE_ENDPOINT, [], [], [], json_encode([
            'product' => 2,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P20',
            'paymentProcessor' => 'stripe'
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPurchaseEndpointError()
    {
        $client = static::createClient();

        $client->request('POST', self::PURCHASE_ENDPOINT, [], [], [], json_encode([
            'product' => 2,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P20',
            'paymentProcessor' => 'crypto'
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
