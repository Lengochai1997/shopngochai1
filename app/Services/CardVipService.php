<?php

namespace App\Services;

use GuzzleHttp\Client;

class CardVipService
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendCard($networkCode, $price, $number, $serial, $tranId)
    {
        // new client guzzle
        $client = new Client([
            'base_uri' => 'http://partner.cardvip.vn/api/',
            'headers'=>[
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 60,
            ]
        ]);
        // create data
        $data = [
            'APIKey' => $this->apiKey,
            'NetworkCode' => $networkCode,
            'PricesExchange' => $price,
            'NumberCard' => $number,
            'SeriCard' => $serial,
            'IsFast' => true,
            'RequestId' => $tranId
        ];
        $res = $client->post('createExchange', [
            'body' => json_encode($data),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($res->getBody(), true);
    }
}
