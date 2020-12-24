<?php

namespace App\Http\Controllers\VirtualHistory;

use App\HistorySpin;
use App\HistorySpinCoin;
use App\Http\Controllers\Controller;
use App\Spin;
use App\SpinCoin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class VirtualHistoryController extends Controller
{
    private $spin;
    private $spinCoin;
    private $user;
    private $historySpin;
    private $historySpinCoin;

    public function __construct(Spin $spin,
                                SpinCoin $spinCoin,
                                User $user,
                                HistorySpin $historySpin,
                                HistorySpinCoin $historySpinCoin)
    {
        $this->spin = $spin;
        $this->spinCoin = $spinCoin;
        $this->user = $user;
        $this->historySpin = $historySpin;
        $this->historySpinCoin = $historySpinCoin;
    }

    public function create(Request $request)
    {
        if (!$request->has('type') || !$request->has('id')) {
            abort(404);
        }
        $type = $request->input('type');
        $id = $request->input('id');
        return view('admin.virtual.create', compact('type', 'id'));
    }

    public function createUsers(Request $request)
    {
        $count = $request->input('count_user');
        if ($count <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng phải lớn hơn 0'
            ], 205);
        }
        for ($i = 0; $i < $count; $i++) {
            $str = Str::random(6);
            $user = [
                'name' => $str,
                'username' => $str,
                'email' => $str.'@gmail.com',
                'tel' => '',
                'password' => bcrypt('123456aa@'),
            ];

            $r = $this->user->create($user);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm ' . $count . ' user'
        ], 200);
    }

    public function createHistories(Request $request)
    {
        $count = $request->input('count_history');
        if ($count <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng phải lớn hơn 0'
            ], 205);
        }
        $type = $request->input('type');
        $spin_id = $request->input('spin_id');

        // get result
        $spin = null;
        if ($type == 'spin') {
            $spin = $this->spin->find($spin_id);

        } else if ($type == 'spin_coin') {
            $spin = $this->spinCoin->find($spin_id);
        }
        if ($spin == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tồn tại vòng quay'
            ], 205);
        }
        $properties = json_decode($spin->properties, true);

        for ($i = 0; $i < $count; $i++) {
            $result = Arr::random($properties, 1);
            $user = $this->user->inRandomOrder()->get();

            if ($type == 'spin') {
                $history = [
                    'user_id' => $user[0]->id,
                    'spin_id' => $spin_id,
                    'spin_account_id' => 0,
                    'result' => $result[0]
                ];
                $this->historySpin->create($history);
            } else if ($type == 'spin_coin') {
                $history = [
                    'user_id' => $user[0]->id,
                    'spin_coin_id' => $spin_id,
                    'spin_account_id' => 0,
                    'result' => $result[0]
                ];
                $this->historySpinCoin->create($history);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm ' . $count . ' lịch sử ảo'
        ], 200);
    }
}
