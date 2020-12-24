<?php

namespace App\Http\Controllers\Charge;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Charge;

class CallbackController extends Controller
{
    private $charge;

    public function __construct(Charge $charge)
    {
        $this->charge = $charge;
    }

    public function napTheNhanh(Request $request)
    {
        if (!$request->has('tranid') || !$request->has('pin') || !$request->has('serial') || !$request->has('callback_sign')) {
            die();
        }
        $attr = $request->all();
        $config = getConfig(config('setting.NAPTHENHANH'));
        $partner_key = $config['key'];
        $callback_sign = md5($partner_key.$attr['tranid'].$attr['pin'].$attr['serial']);

        if ($callback_sign !== $attr['callback_sign']) {
            return response()->json([
                'message' => 'Giao dịch không hợp lệ.',
                'status' => 'error'
            ], 500);
        }
        $status = $attr['status'];
        $tran_id = $attr['tranid'];

        $charge = $this->charge->where('tran_id', $tran_id)->firstOrFail();
        // check status card
        if ($charge && $charge->status != 1) {
            return response()->json([
                'message' => 'Thẻ đã được nạp',
                'status' => 'error'
            ], 500);
        }

        if (intval($status) === 1) {
            $percent = $charge->payment->percent;
            if ($charge && $percent) {
                $charge->update([
                    'status' => 2
                ]);
                $amount = $charge->amount * ($percent/100);
                UserService::plusMoney($charge->user_id, $amount);
                appendTopCharge($charge->user_id, $charge->amount);
            }
        } else {
            if ($charge) {
                $charge->update([
                    'status' => 3
                ]);
            }
        }
    }

    public function muaCard(Request $request)
    {
        if(!$request->has('trans_id') || empty($request->input('trans_id'))) {
            die();
        }
        if(!$request->has('amount')) {
            die();
        }
        if(!$request->has('status') || empty($request->input('status'))) {
            die();
        }
        if(!$request->has('description')) {
            die();
        }
        if(!$request->has('signature') || empty($request->input('signature'))) {
            die();
        }
        // get config
        $config = getConfig(config('setting.MUACARD'));
        $api_key = $config['key'];
        // create sign nature
        $signature = md5($api_key . $request->input('trans_id'));
        // check sign nature
        if($signature != $request->input('signature')) {
            return response()->json([
                'message' => 'Giao dịch không hợp lệ.',
                'status' => 'error'
            ], 500);
        }

        $charge = $this->charge->where('tran_id', intval($request->input('trans_id')))->firstOrFail();

        // check charge status
        if ($charge && $charge->status != 1) {
            return response()->json([
                'message' => 'Thẻ đã được nạp',
                'status' => 'error'
            ], 500);
        }


        if($request->input('status') != "3") {
            if($charge) {
                $charge->update([
                    'status' => 3
                ]);
            }
        } else {
            $percent = $charge->payment->percent;
            if($charge && $percent) {
                $charge->update([
                    'status' => 2
                ]);
                $amount = $charge->amount * ($percent/100);
                UserService::plusMoney($charge->user_id, $amount);
                appendTopCharge($charge->user_id, $charge->amount);
            }
        }
    }

    public function cardVip(Request $request)
    {
        if(!$request->has('requestid')) {
            die();
        }
        $tranId = $request->requestid;
        $pin = $request->card_code;
        $serial = $request->card_seri;
        $checkCharge = $this->charge->where('tran_id', intval($tranId))->where('pin', $pin)->where('serial', $serial)->count();
        if ($checkCharge == 0) {
            return response()->json([
                'message' => 'Thẻ cào không tồn tại trên hệ thống',
                'status' => 'error'
            ], 500);
        }
        $status = $request->status;
        $amount = $request->value_receive;
        $pricesvalue = $request->pricesvalue;

        $charge = $this->charge->where('tran_id', intval($tranId))->firstOrFail();
        // check charge status
        if ($charge && $charge->status != 1) {
            return response()->json([
                'message' => 'Thẻ đã được nạp',
                'status' => 'error'
            ], 500);
        }

        if ($status == 200 && $amount == $pricesvalue) {
            // card true
            $percent = $charge->payment->percent;
            if($charge) {
                $charge->update([
                    'status' => 2
                ]);
                $amount = $charge->amount * ($percent/100);
                UserService::plusMoney($charge->user_id, $amount);
                appendTopCharge($charge->user_id, $charge->amount);
            }
        } else {
            // card false
            if($charge) {
                $charge->update([
                    'status' => 3
                ]);
            }
        }
    }

    public function napTuDong(Request $request)
    {
        // check callback_sign
        if (!$request->has('callback_sign')) {
            return abort(404);
        }
        // get config
        $config = getConfig(config('setting.NAPTUDONG'));
        $partner_key = $config['partner_key'];
        $callback_sign = md5($partner_key . $request->input('code') . $request->input('serial'));

        $charge = $this->charge->where('tran_id', intval($request->input('request_id')))->firstOrFail();

        // check charge status
        if ($charge && $charge->status != 1) {
            return response()->json([
                'message' => 'Thẻ đã được nạp',
                'status' => 'error'
            ], 500);
        }

        if ($request->input('callback_sign') == $callback_sign) {
            // get charge by tran_id
            if (!$charge || $charge->status != 1) {
                return abort(404);
            }
            $status = $request->input('status');
            switch ($status) {
                case 1:
                    // card true => change status and plus money for user
                    $charge->update([
                        'status' => 2
                    ]);
                    // update money user && update top charge
                    $percent = $charge->payment->percent;
                    $amount = $charge->amount * ($percent/100);
                    UserService::plusMoney($charge->user_id, $amount);
                    appendTopCharge($charge->user_id, $charge->amount);
                    break;
                case 2:
                case 3:
                    // card false => change status => 3
                    $charge->update([
                        'status' => 3
                    ]);
                    break;
                case 99:
                    // dont process
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Callback in process'
                    ], 200);
                default:
                    return abort(404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Callback success'
            ], 200);
        }
    }
}
