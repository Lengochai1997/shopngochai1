<?php

namespace App\Services;

class ChargeService {
    private $url = 'http://sys.napthenhanh.com/api/charging-wcb';
    private $partner_id;
    private $partner_key;
    public function __construct($partner_id, $partner_key)
    {
        $this->partner_id = $partner_id;
        $this->partner_key = $partner_key;
    }

    public function sendCard($type, $pin, $serial, $amount)
    {
        $tran_id = time() . rand(10000, 99999);
        /// create sign
        $sign = md5($this->partner_id . $this->partner_key . $type . $pin . $serial . $amount . $tran_id);
        $data = array();
        $data['partner_id'] = $this->partner_id;
        $data['type'] = $type;
        $data['pin'] = $pin;
        $data['serial'] = $serial;
        $data['amount'] = $amount;
        $data['sign'] = $sign;
        $data['tranid'] = $tran_id;
        if (is_array($data)) {
            $dataPost = http_build_query($data);
        } else {
            $dataPost = $data;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        if ($result) {
            return $result;
        }
    }

}
