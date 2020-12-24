<?php

namespace App\Http\Controllers\Charge;

use App\Charge;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Services\CardVipService;
use App\Services\ChargeService;
use App\Services\MuaCardService;
use App\Services\NapTuDongService;
use App\Setting;
use App\Transformer\Charge\ChargeTransformer;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargeController extends Controller
{
    private $payment;
    private $charge;
    private $setting;
    public function __construct(Payment $payment, Charge $charge, Setting $setting)
    {
        $this->payment = $payment;
        $this->charge = $charge;
        $this->setting = $setting;
    }

    public function charge()
    {
        $payments = $this->payment->where('status', 1)->get()->toArray();
        return view('user.charge', compact('payments'));
    }

    public function atm()
    {
        $config_atm = $this->setting->where('key', 'config_atm')->first();
        $config_wallet = $this->setting->where('key', 'config_wallet')->first();
        if ($config_atm !== null && $config_wallet !== null) {
            $config_atm = json_decode($config_atm->value, true);
            $config_wallet = json_decode($config_wallet->value, true);
        }
        return view('user.atm', compact('config_atm', 'config_wallet'));
    }

    public function doCharge(Request $request)
    {
        try {
            if ($request->has('type') && $request->input('type') === 'json') {
                $attr = $request->all();
                $attr = checkRequest($attr);
                if ($request->input('serial')) {
                    $check = $this->charge->where('serial', $request->input('serial'))->where('pin', $request->input('pin'))->count();
                    if ($check > 0) {
                        return response()->json([
                            'message' => 'Thẻ cào đã tồn tại trên hệ thống.',
                            'status' => 'error'
                        ], 500);
                    }
                }
                // get payment id
                $payment = $this->payment->find($attr['payment_id']);
                if ($payment) {
                    if (intval($payment->type_id) === 1) {
                        // get config
                        $config = getConfig(config('setting.NAPTHENHANH'));
                        if (!array_key_exists('id', $config) || !array_key_exists('key', $config)) {
                            return response()->json([
                                'message' => 'Có lỗi xảy ra.',
                                'status' => 'error'
                            ], 500);
                        }
                        // nạp thẻ nhanh
                        if (intval($payment->gate_id) == 1) {
                            // cổng thanh toán của napthenhanh.com
                            $type = $payment['key'];
                            $charge = new ChargeService($config['id'], $config['key']);
                            $sendResult = $charge->sendCard($type, $attr['pin'], $attr['serial'], $attr['amount']);
                            if ($sendResult['status'] != false) {
                                $result = $this->charge->create([
                                    'user_id' => Auth::id(),
                                    'payment_id' => $payment->id,
                                    'amount' => $attr['amount'],
                                    'serial' => $attr['serial'],
                                    'pin' => $attr['pin'],
                                    'status' => 1,
                                    'tran_id' => $sendResult['tranid']
                                ]);
                                if ($result) {
                                    return response()->json([
                                        'message' => trans('message.success.charged'),
                                        'status' => 'success'
                                    ], 200);
                                }
                            }
                        }
                        if (intval($payment->gate_id) == 2) {
                            // cổng thanh toán của muacard.vn
                            $provider = $payment['key'];
                            $serial = $attr['serial'];
                            $code = $attr['pin'];
                            $amount = $attr['amount'];
                            do {
                                $tran_id = rand();
                                $charge = $this->charge->where('tran_id', $tran_id)->get();
                            } while (count($charge) > 0);
                            // get config
                            $config = getConfig(config('setting.MUACARD'));
                            if (!array_key_exists('key', $config) || !array_key_exists('callback', $config)) {
                                return response()->json([
                                    'message' => 'Có lỗi xảy ra.',
                                    'status' => 'error'
                                ], 500);
                            }
                            $charge = new MuaCardService($config['key'], $config['callback']);
                            $result = $charge->charging($provider, $serial, $code, $amount, $tran_id);
                            if ($result['code'] === 200) {
                                $attr['user_id'] = Auth::id();
                                $attr['status'] = 1;
                                $attr['tran_id'] = $tran_id;
                                $result = $this->charge->create($attr);
                                if ($result) {
                                    return response()->json([
                                        'message' => trans('message.success.charged'),
                                        'status' => 'success'
                                    ], 200);
                                }
                            } else {
                                return response()->json([
                                    'message' => 'Giao dịch không thành công, xin thử lại.',
                                    'status' => 'error'
                                ], 500);
                            }
                        }
                        if (intval($payment->gate_id) == 3) {
                            // card vip
                            return $this->cardVipCharge($attr, $payment);
                        }
                        if (intval($payment->gate_id) == 4) {
                            // naptudong.com
                            return $this->napTuDongCharge($attr, $payment);
                        }
                    }
                    if ($payment->type_id == 2) {
                        // nạp thẻ chậm
                        $result = $this->charge->create([
                            'user_id' => Auth::id(),
                            'payment_id' => $payment->id,
                            'amount' => $attr['amount'],
                            'serial' => $attr['serial'],
                            'pin' => $attr['pin'],
                            'status' => 1,
                        ]);
                        return response()->json([
                            'message' => trans('message.success.charged'),
                            'status' => 'success'
                        ], 200);
                    }
                }

                return response()->json([
                    'message' => trans('message.error.charged'),
                    'status' => 'error'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra.',
                'status' => 'error'
            ], 500);
        }
    }

    private function cardVipCharge($attr, $payment)
    {
        // get config
        $config = getConfig(config('setting.CARDVIP'));
        if (!array_key_exists('key', $config)) {
            return response()->json([
                'message' => 'Có lỗi xảy ra.',
                'status' => 'error'
            ], 500);
        }
        // get info card
        $provider = $payment['key'];
        $serial = $attr['serial'];
        $code = $attr['pin'];
        $amount = $attr['amount'];
        // generator tran_id
        do {
            $tran_id = rand();
            $charge = $this->charge->where('tran_id', $tran_id)->get();
        } while (count($charge) > 0);
        // creator service
        $cardVip = new CardVipService($config['key']);
        // send card
        $result = $cardVip->sendCard($provider, $amount, $code, $serial, $tran_id);
        if ($result['status'] == 200) {
            $attr['user_id'] = Auth::id();
            $attr['status'] = 1;
            $attr['tran_id'] = $tran_id;
            $result = $this->charge->create($attr);
            if ($result) {
                return response()->json([
                    'message' => trans('message.success.charged'),
                    'status' => 'success'
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Có lỗi xảy ra.',
                'status' => 'error'
            ], 500);
        }
    }

    private function napTuDongCharge(array $attr, $payment)
    {
        // get config
        $config = getConfig(config('setting.NAPTUDONG'));
        if (!array_key_exists('partner_id', $config) || !array_key_exists('partner_key', $config)) {
            return response()->json([
                'message' => 'Có lỗi xảy ra.',
                'status' => 'error'
            ], 500);
        }
        // get key payment
        $payment_key = $payment['key'];
        // get info card
        $serial = $attr['serial'];
        $code = $attr['pin'];
        $amount = $attr['amount'];
        // generator tran_id
        do {
            $tran_id = rand();
            $charge = $this->charge->where('tran_id', $tran_id)->get();
        } while (count($charge) > 0);
        $partner_id = $config['partner_id'];
        $partner_key = $config['partner_key'];

        $service = new NapTuDongService($partner_id, $partner_key);
        $response = $service->charging($payment_key, $serial, $code, $amount, $tran_id);
        // charge item
        $charge = [
            'user_id' => Auth::id(),
            'payment_id' => $payment['id'],
            'amount' => $response['declared_value'],
            'serial' => $response['serial'],
            'pin' => $response['code'],
            'tran_id' => $tran_id
        ];
        // get status by response
        $status = $response['status'];
        // check status
        switch ($status) {
            case 99:
                // card in process
                $charge['status'] = 1;
                break;
            case 1:
                // card true => change status => 2
                $charge['status'] = 2;
                break;
            case 2:
                // card true but wrong value => get value in response => change status = 4
                $charge['status'] = 4;
                break;
            case 3:
                // card false => change status = 3
                $charge['status'] = 3;
                break;
            case 4:
                // system maintenance => out switch
                return response()->json([
                    'message' => 'Máy chủ bảo trì.',
                    'status' => 'error'
                ], 500);
            default:
                // error => out switch
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
        }
        // insert to database
        $result = $this->charge->create($charge);
        // return response success
        return response()->json([
            'message' => trans('message.success.charged'),
            'status' => 'success',
            'result' => $result
        ], 200);
    }

    public function charged()
    {
        $payments = $this->payment->all()->toArray();
        return view('user.charged', compact('payments'));
    }

    public function chargeList(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $payment_id = $request->has('payment_id') ? intval($request->input('payment_id')) : 0;
        $status = $request->has('status') ? intval($request->input('status')) : 0;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';

        $charges = $this->charge
            ->join('payments', 'charges.payment_id', 'payments.id')
            ->select('charges.*', 'payments.type_id')
            ->where('charges.user_id', Auth::id())
            ->where(function ($query) use ($payment_id) {
                if ($payment_id != 0) {
                    $query->where('payments.id', $payment_id);
                }
            })
            ->where(function ($query) use ($status) {
                if($status != 0) {
                    $query->where('charges.status', $status);
                }
            })
            ->where('charges.pin', 'like', "%{$sSearch}%")
            ->where('charges.serial', 'like', "%{$sSearch}%")
            ->orderBy('charges.id', 'desc')
            ->offset($offset)->limit($limit)
            ->get();
        $count = $this->charge
            ->join('payments', 'charges.payment_id', 'payments.id')
            ->select('charges.*', 'payments.type_id')
            ->where('charges.user_id', Auth::id())
            ->where(function ($query) use ($payment_id) {
                if ($payment_id != 0) {
                    $query->where('payments.id', $payment_id);
                }
            })
            ->where(function ($query) use ($status) {
                if($status != 0) {
                    $query->where('charges.status', $status);
                }
            })
            ->where('charges.pin', 'like', "%{$sSearch}%")
            ->where('charges.serial', 'like', "%{$sSearch}%")
            ->orderBy('charges.id', 'desc')
            ->count();
        $data = ChargeTransformer::forDataTable($charges);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ], 200);
    }
}
