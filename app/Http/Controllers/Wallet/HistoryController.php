<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Services\TichHopService;
use App\Transformer\Wallet\WalletTransformer;
use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class HistoryController extends Controller
{
    private $walletHistory;
    private $wallet;

    public function __construct(WalletHistory $walletHistory, Wallet $wallet)
    {
        $this->walletHistory = $walletHistory;
        $this->wallet = $wallet;
    }

    public function index(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $type = $request->has('type') ? $request->input('type') : '';
        $histories = $this->walletHistory
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($type) {
                if ($type != '') {
                    $query->where('coin_type', $type);
                }
            })
            ->orderBy('id', 'desc')
            ->offset($offset)->limit($limit)
            ->get();
        $count = $this->walletHistory
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->offset($offset)->limit($limit)
            ->count();
        $data = WalletTransformer::forDataTables($histories);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ], 200);
    }

    public function withoutQuanhuy(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'json') {
            $attr = checkRequest($request->all());
            $value = array_key_exists('value', $attr) ? intval($attr['value']) : 0;
            // check value < 0
            if ($value <= 0) {
                return response()->json([
                    'message' => 'Giao dịch không hợp lệ.',
                    'status' => 'error'
                ]);
            }
            // get data
            $username = array_key_exists('username', $attr) ? $attr['username'] : '';
            $password = array_key_exists('password', $attr) ? $attr['password'] : '';
            $data = [
                'username' => $username,
                'password' => $password
            ];
            // get wallet
            $wallet = $this->wallet->where('user_id', Auth::id())->first();
            if ($wallet && intval($wallet->quanhuy) >= $value) {
                $config = getConfig(config('setting.TICHHOP'));
                $send = [];
                if (isset($config['quanhuy']) && $config['quanhuy'] == 1) {
                    $send = $this->sendRequestTichHop('lienquan', '', $username, $password, $value);
                    if ($send['result']['status'] !== 0) {
                        return response()->json([
                            'message' => 'Giao dịch thất bại hoặc Thông tin không đúng.',
                            'status' => 'error'
                        ], 400);
                    }
                }
                // add to wallet histories
                $history = $this->walletHistory->create([
                    'user_id' => Auth::id(),
                    'coin_type' => 'quanhuy',
                    'coin_count' => $value,
                    'data' => json_encode($data),
                    'status' => 0,
                    'key' => isset($send['key']) ? $send['key'] : ''
                ]);
                // change data in wallet
                $wallet->update([
                    'quanhuy' => (int)$wallet->quanhuy - $value
                ]);
                if ($history) {
                    return response()->json([
                        'message' => 'Giao dịch đã được gửi lên, vui lòng đợi admin duyệt.',
                        'status' => 'success'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Bạn không đủ quân huy.',
                    'status' => 'error'
                ], 200);
            }
        }
    }

    public function withoutKimcuong(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'json') {
            $attr = checkRequest($request->all());
            $value = array_key_exists('value', $attr) ? intval($attr['value']) : 0;
            // check value < 0
            if ($value <= 0) {
                return response()->json([
                    'message' => 'Giao dịch không hợp lệ.',
                    'status' => 'error'
                ]);
            }
            // get data
            $id = array_key_exists('id', $attr) ? $attr['id'] : '';
            $data = [
                'id' => $id
            ];
            // get wallet
            $wallet = $this->wallet->where('user_id', Auth::id())->first();
            if ($wallet && intval($wallet->kimcuong) >= $value) {
                $config = getConfig(config('setting.TICHHOP'));
                $send = [];
                if (isset($config['kimcuong']) && $config['kimcuong'] == 1) {
                    $send = $this->sendRequestTichHop('freefire', $data['id'], '', '', $value);
                    if ($send['result']['status'] !== 0) {
                        return response()->json([
                            'message' => 'Giao dịch thất bại hoặc Thông tin không đúng.',
                            'status' => 'error'
                        ], 400);
                    }
                }
                // add to wallet histories
                $history = $this->walletHistory->create([
                    'user_id' => Auth::id(),
                    'coin_type' => 'kimcuong',
                    'coin_count' => $value,
                    'data' => json_encode($data),
                    'status' => 0,
                    'key' => isset($send['key']) ? $send['key'] : ''
                ]);

                // change data in wallet
                $wallet->update([
                    'kimcuong' => (int)$wallet->kimcuong - $value
                ]);
                if ($history) {
                    return response()->json([
                        'message' => 'Giao dịch đã được gửi lên, vui lòng đợi admin duyệt.',
                        'status' => 'success'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Bạn không đủ kim cương.',
                    'status' => 'error'
                ], 200);
            }
        }
    }

    public function approved(Request $request, $id)
    {
        // change status ==> 1
        $walletHistory = $this->walletHistory->find($id);
        if ($walletHistory) {
            $walletHistory->update([
                'status' => 1
            ]);
            return response()->json([
                'message' => 'Phê duyệt thành công.',
                'status' => 'success'
            ], 200);
        }
    }

    public function refuse(Request $request, $id)
    {
        // change status ==> 2
        $walletHistory = $this->walletHistory->find($id);
        if ($walletHistory) {
            $walletHistory->update([
                'status' => 2
            ]);
        }
        // restore coin for member
        $wallet = $this->wallet->where('user_id', $walletHistory->user_id)->first();
        if ($wallet) {
            if ($walletHistory->coin_type === 'kimcuong') {
                $wallet->update([
                    'kimcuong' => $wallet->kimcuong + $walletHistory->coin_count
                ]);
            }
            if ($walletHistory->coin_type === 'quanhuy') {
                $wallet->update([
                    'quanhuy' => $wallet->quanhuy + $walletHistory->coin_count
                ]);
            }
        }
        return response()->json([
            'message' => 'Từ chối thành công.',
            'status' => 'success'
        ], 200);
    }

    /**
     * @param $provider: 'lienquan' | 'freefire';
     * @param string $id
     * @param string $username
     * @param string $password
     * @param string $value
     */
    public function sendRequestTichHop($provider, $id = '', $username = '', $password = '', $value = 0) {
        // generate key
        do {
            $key = Str::random(9);
            $check = $this->walletHistory->where('key', $key)->count();
        } while($check > 0);
        $provider = [
            'provider' => $provider,
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'item' => config('tichhop.'.$provider)[$value],
            'callback' => url('/').'/callback/tichhop/'.$key
        ];
        $secret = getConfig(config('setting.TICHHOP'))['secret'];
        $tichHop = new TichHopService($secret);
        $result = $tichHop->sms($provider);
        return [
            'key' => $key,
            'result' => $result
        ];
    }

}
