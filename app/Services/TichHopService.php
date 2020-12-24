<?php

namespace App\Services;

class TichHopService {
    protected $test = true; /* chế độ thử nghiệm: true, chế độ chạy thật: false */
    protected $secret = 'vuha98_5f254e6f0154d'; /*mã bí mật tài khoản api*/
    protected $url = 'http://tichhop.net/auto-api-3ji231h';

    public function __construct($secret = '')
    {
        if ($secret !== '') {
            $this->secret = $secret;
            $this->test = false;
        }
    }

    function sms($input){
        $input['secret'] = $this->secret;
        if ($this->test){
            $input['beta'] = 1;
        }
        $curl = curl_init();
        $url = $this->url.'?'.http_build_query($input);
        CURL_SETOPT($curl,CURLOPT_URL, $url);
        CURL_SETOPT($curl,CURLOPT_USERAGENT, "User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53");
        CURL_SETOPT($curl,CURLOPT_RETURNTRANSFER, True);
        CURL_SETOPT($curl,CURLOPT_FOLLOWLOCATION, True);
        CURL_SETOPT($curl,CURLOPT_CONNECTTIMEOUT, 60);
        CURL_SETOPT($curl,CURLOPT_TIMEOUT, 60);
        $exec = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        if (!empty($error_msg)) {
            return ['status' => 2, 'message' => 'Lỗi kết nối api sms'];
        }
        $result = json_decode($exec, true);
        return $result;
    }
}
