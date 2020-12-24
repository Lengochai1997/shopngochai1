<?php

namespace App\Http\Controllers\Test;

use App\Charge;
use App\Http\Controllers\Controller;
use App\Services\MuaCardService;
use App\Services\UserService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Auth;

class TestController extends Controller
{
    private $charge;

    public function __construct(Charge $charge)
    {
        $this->charge = $charge;
    }

    public function test(Request $request)
    {
        do {
            $tran_id = rand();
            $charge = $this->charge->where('tran_id', $tran_id)->get();
        } while (count($charge) > 0);

        $serial = '10005916029282';
        $code = '718912630813159';
        $amount = '10000';
        $charging = new MuaCardService();
        $result = $charging->charging('viettel', $serial, $code, $amount, $tran_id);
        if ($result === true) {
            $this->charge->create([
                'user_id' => 2,
                'payment_id' => 5,
                'amount' => 10000,
                'pin' => $code,
                'serial' => $serial,
                'status' => 1,
                'tran_id' => $tran_id
            ]);
        }
    }

    public function testCharge()
    {
        $client = new Client([
            'base_uri' => 'http://partner.cardvip.vn/api/',
            'headers'=>[
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=UTF8',
                'timeout' => 60,
            ]
        ]);
        $data = [
            'APIKey' => '8a947624-a180-4ac9-9fe0-959f6ea8c565',
            'NetworkCode' => 'VIETTEL',
            'PricesExchange' => 10000,
            'NumberCard' => '513227064022057',
            'SeriCard' => '10004960038026',
            'IsFast' => true,
            'RequestId' => 12121
        ];
        $res = $client->post('createExchange', [
            'body' => json_encode($data),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
        $body = json_decode($res->getBody());
        $statusCode = $res->getStatusCode();

        echo '<pre>';
        print_r($body);
        echo '</pre>';
        echo 'Code ' . $statusCode;
    }
}
