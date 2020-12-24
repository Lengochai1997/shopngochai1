<?php

namespace App\Http\Controllers\Spin;

use App\HistorySpinCoin;
use App\HistorySpinCoinTotal;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\SpinCoin;
use App\Star;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;

class SpinCoinController extends Controller
{
    private $spinCoin;
    private $star;
    private $historySpinCoin;
    private $historySpinCoinTotal;
    private $wallet;

    public function __construct(SpinCoin $spinCoin,
                                Star $star,
                                HistorySpinCoin $historySpinCoin,
                                HistorySpinCoinTotal $historySpinCoinTotal,
                                Wallet $wallet)
    {
        $this->spinCoin = $spinCoin;
        $this->star = $star;
        $this->historySpinCoin = $historySpinCoin;
        $this->historySpinCoinTotal = $historySpinCoinTotal;
        $this->wallet = $wallet;
    }

    public function index(Request $request, $id)
    {
        $spin = $this->spinCoin->find($id);
        $histories = $this->historySpinCoin
            ->where('spin_coin_id', $id)
            ->orderBy('id', 'desc')->offset(0)->limit(25)->get();
        if (!$histories) {
            $histories = [];
        }
        return view('spin_coin.index', compact('spin', 'histories'));
    }

    public function getResult($id)
    {
        // check login
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Bạn chưa đăng nhập.',
                'status' => 'error'
            ], 401);
        }
        // get info spin
        $spin = $this->spinCoin->find($id);
        // check money user
        if (Auth::user()->total_money < $spin->price) {
            return response()->json([
                'message' => 'Tài khoản bạn không đủ tiền.',
                'status' => 'not_money'
            ], 200);
        }
        $properties = json_decode($spin->properties, true);
        $ratio = json_decode($spin->ratio, true);

        // check user in star
        $star = $this->star
            ->where('type', 'spin_coin')
            ->where('type_id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if ($star) {
            $ratio = json_decode($star->value);
        }

        $arrResult = [];
        foreach ($ratio as $key => $value) {
            for ($i = 0; $i < intval($value); $i++) {
                array_push($arrResult, $key);
            }
        }
        if (count($arrResult) === 0) {
            return response()->json([
                'message' => 'Có lỗi xảy ra.',
                'status' => 'error'
            ], 500);
        }
        UserService::minusMoney(Auth::id(), $spin->price);

        $rand = rand(0, count($arrResult));
        $result = $arrResult[$rand];

        $value = $properties[$result];

        if ($result === intval($spin->pro_total)) {
            // nổ hũ
            $total = $spin->total;
            // update spin coin data
            $spin->update([
                'total' => 0,
                'total_turns' => $spin->total_turns + 1,
            ]);
            // add to history
            $this->historySpinCoin->create([
                'user_id' => Auth::id(),
                'spin_coin_id' => $spin->id,
                'result' => $total . ' ' . config('coin.type')[$spin->type]
            ]);
            // add to history spin coin total
            $this->historySpinCoinTotal->create([
                'user_id' => Auth::id(),
                'spin_coin_id' => $spin->id,
                'total' => $total
            ]);
            // update to wallet
            $this->updateWallet($spin, $total);
            return response()->json([
                'ratio' => 45*$result,
                'message' => 'Nổ hũ rồi !!!'
            ], 200);
        }

        // update to wallet
        $this->updateWallet($spin, $value);

        // update turn spin coin
        $spin->update([
            'count_turn' => $spin->count_turn + 1,
        ]);
        // save data
        $this->historySpinCoin->create([
            'user_id' => Auth::id(),
            'spin_coin_id' => $spin->id,
            'result' => $properties[$result] . ' ' . config('coin.type')[$spin->type]
        ]);

        $txtResult = $properties[$result];

        // return response
        return response()->json([
            'ratio' => 45*$result,
            'message' => 'Chúc mừng bạn quay được ' . $txtResult . ' ' . config('coin.type')[$spin->type]
        ], 200);
    }

    private function updateWallet($spin, $value)
    {
        // add to wallet user
        $wallet = $this->wallet->where('user_id', Auth::id())->first();
        if ($wallet) {
            $type = $spin->type;
            if ($type == 'kimcuong') {
                $wallet->update([
                    'kimcuong' => $wallet->kimcuong + $value
                ]);
            } else if ($type == 'quanhuy') {
                $wallet->update([
                    'quanhuy' => $wallet->quanhuy + $value
                ]);
            }
        } else {
            $type = $spin->type;
            if ($type == 'kimcuong') {
                $this->wallet->create([
                    'user_id' => Auth::id(),
                    'kimcuong' => $value,
                    'quanhuy' => 0,
                ]);
            } else if ($type == 'quanhuy') {
                $this->wallet->create([
                    'user_id' => Auth::id(),
                    'quanhuy' => $value,
                    'kimcuong' => 0
                ]);
            }
        }
    }
}
