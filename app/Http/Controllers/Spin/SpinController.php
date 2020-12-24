<?php

namespace App\Http\Controllers\Spin;

use App\HistorySpin;
use App\HistorySpinTotal;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Spin;
use App\SpinAccount;
use App\Star;
use Illuminate\Http\Request;
use Auth;

class SpinController extends Controller
{
    private $spin;
    private $spinAccount;
    private $star;
    private $historySpin;
    private $historySpinTotal;

    public function __construct(Spin $spin,
                                SpinAccount $spinAccount,
                                Star $star,
                                HistorySpin $historySpin,
                                HistorySpinTotal $historySpinTotal)
    {
        $this->spin = $spin;
        $this->spinAccount = $spinAccount;
        $this->star = $star;
        $this->historySpin = $historySpin;
        $this->historySpinTotal = $historySpinTotal;
    }

    public function index(Request $request, $id)
    {
        $spin = $this->spin->find($id);
        $histories = $this->historySpin->orderBy('id', 'desc')->offset(0)->limit(25)->get();
        return view('spin.index', compact('spin', 'histories'));
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
        // find spin
        $spin = $this->spin->find($id);
        // check count money spin
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
            ->where('type', 'spin')
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

        if ($result === intval($spin->pro_total)) {
            $total = $spin->total;
            UserService::plusMoney(Auth::id(), $total);
            $spin->update([
                'total' => 0,
                'total_turns' => $spin->total_turns + 1,
            ]);

            $this->historySpin->create([
                'user_id' => Auth::id(),
                'spin_id' => $id,
                'spin_account_id' => 0,
                'result' => $properties[$result]
            ]);
            $this->historySpinTotal->create([
                'user_id' => Auth::id(),
                'spin_id' => $id,
                'total' => $total
            ]);
            return response()->json([
                'ratio' => 45*$result,
                'message' => 'Nổ hũ rồi !!!'
            ], 200);
        }

        if ($result === intval($spin->pro_special)) {
            $spin->update([
                'total' => $spin->total + $spin->price,
                'total_turns' => $spin->total_turns + 1,
            ]);

            $this->historySpin->create([
                'user_id' => Auth::id(),
                'spin_id' => $id,
                'spin_account_id' => 0,
                'result' => $properties[$result]
            ]);

            $coinType = config('spin.special')[$spin->special_type];
            $coinValue = $spin->special_value;
            updateWalletUser($coinType, $coinValue);

            return response()->json([
                'ratio' => 45*$result,
                'message' => 'Chúc mừng bạn quay được ' . $properties[$result]
            ], 200);
        }

        $spin->update([
            'total' => $spin->total + $spin->price,
            'total_turns' => $spin->total_turns + 1,
        ]);

        $accounts = $this->spinAccount
            ->where('spin_id', $id)
            ->where('type_id', $result)
            ->where('status', 0)
            ->get();

        if (count($accounts) === 0) {
            $data = [
                'user_id' => Auth::id(),
                'spin_id' => $id,
                'spin_account_id' => 0,
                'result' => 'Đang cập nhật tài khoản'
            ];
        } else {
            $account = $accounts[0];
            $data = [
                'user_id' => Auth::id(),
                'spin_id' => $id,
                'spin_account_id' => $account->id,
                'result' => $properties[$result]
            ];
            // update account
            $account->update(['status' => 2]);
        }
        // save data
        $this->historySpin->create($data);

        $txtResult = $properties[$result];

        // return response
        return response()->json([
            'ratio' => 45*$result,
            'message' => 'Chúc mừng bạn quay được ' . $txtResult
        ], 200);
    }
}
