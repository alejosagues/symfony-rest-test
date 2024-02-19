<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatePriceControllerTest extends WebTestCase
{
    const CALCULATE_PRICE_ENDPOINT = '/calculate-price';

    public function testCalculatePriceDETaxCode10Discount()
    {
        $client = static::createClient();

        $client->request('POST', self::CALCULATE_PRICE_ENDPOINT, [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P10'
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), json_encode($data));
        $this->assertEquals(107.1, $data['price']);
    }

    public function testCalculatePriceDETaxCode20Discount()
    {
        $client = static::createClient();

        $client->request('POST', self::CALCULATE_PRICE_ENDPOINT, [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'P20'
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(95.2, $data['price']);
    }

    public function testCalculatePriceGRTaxCode20Discount()
    {
        $client = static::createClient();

        $client->request('POST', self::CALCULATE_PRICE_ENDPOINT, [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'GR123456789',
            'couponCode' => 'P20'
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(99.2, $data['price']);
    }

    public function testCalculatePriceGRTaxCode100Discount()
    {
        $client = static::createClient();

        $client->request('POST', self::CALCULATE_PRICE_ENDPOINT, [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'GR123456789',
            'couponCode' => 'P100'
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(0, $data['price']);
    }

    public function testCalculatePriceEndpointError()
    {
        $client = static::createClient();

        $client->request('POST', self::CALCULATE_PRICE_ENDPOINT, [], [], [], json_encode([
            'product' => 3,
            'taxNumber' => 'GxR123456789',
            'couponCode' => 'P20'
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals("taxNumber", $data['errors'][0]['field']);
    }
}
