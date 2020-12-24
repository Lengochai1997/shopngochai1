<?php


namespace App\Services;


class NapTuDongService
{
    private $partner_id;
    private $partner_key;
    private $url = 'http://api.naptudong.com/chargingws/v2';
    private $command  = 'charging';

    public function __construct($partner_id, $partner_key)
    {
        $this->partner_id = $partner_id;
        $this->partner_key = $partner_key;
    }

    public function charging($payment_key, $serial, $code, $amount, $tran_id)
    {
        $dataPost = array();
        $dataPost['request_id'] = $tran_id;
        $dataPost['code'] = $code;
        $dataPost['partner_id'] = $this->partner_id;
        $dataPost['serial'] = $serial;
        $dataPost['telco'] = $payment_key;
        $dataPost['command'] = $this->command;
        ksort($dataPost);
        $sign = $this->partner_key;
        foreach ($dataPost as $item) {
            $sign .= $item;
        }
        $mySign = md5($sign);
        $dataPost['amount'] = $_POST['amount'];
        $dataPost['sign'] = $mySign;

        $data = http_build_query($dataPost);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        curl_setopt($ch, CURLOPT_REFERER, $actual_link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }


}
