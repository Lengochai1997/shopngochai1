<?php

namespace App\Services;

class MuaCardService {
    private $url = 'http://muacard.vn/api/charging';
    private $charging_type = 1;
    private $api_key;
    private $callback;

    public function __construct($api_key, $callback)
    {
        $this->api_key = $api_key;
        $this->callback = $callback;
    }

    public function charging($provider, $serial, $code, $amount, $tran_id)
    {
        $query = [
            'charging_type' => $this->charging_type,
            'provider' => $provider,
            'serial' => $serial,
            'code' => $code,
            'amount' => $amount,
            'api_key' => $this->api_key,
            'trans_id' => $tran_id,
            'callback' => $this->callback
        ];
        $query = http_build_query($query);

        $url = $this->url.'?'.$query;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($data, true);

        if ($response) {
            return $response;
        }
    }
}
