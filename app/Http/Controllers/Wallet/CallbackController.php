<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    private $walletHistory;
    private $wallet;

    public function __construct(WalletHistory $walletHistory, Wallet $wallet)
    {
        $this->walletHistory = $walletHistory;
        $this->wallet = $wallet;
    }

    public function tichHop(Request $request, $key)
    {
        // check has request status
        if (!$request->has('status')) {
            return response('Khong co trang thai', 200);
        }
        $walletHistory = $this->walletHistory->where('key', $key)->first();
        // check has history in wallet histories
        if (!$walletHistory) {
            return response('Giao dich khong ton tai', 200);
        }
        if ($walletHistory->status == 1 || $walletHistory->status == 2 || $walletHistory->status == 3) {
            return response('Giao dich da duoc xu ly truoc day', 200);
        }
        // check status
        $status = $request->input('status');
        switch ($status) {
            case 1:
                // trade success
                // change status wallet history
                $walletHistory->update([
                    'status' => 1
                ]);
                break;
            case 2:
                // trade error because server maintenance
                // change status wallet history
                $walletHistory->update([
                    'status' => 2
                ]);
                // update wallet user - backup coin wallet user
                // updateWalletUser($walletHistory->coin_type, $walletHistory->coin_count, $walletHistory->user_id);
                break;
            case 3:
                // trade error
                $walletHistory->update([
                    'status' => 2
                ]);
                // update wallet user - backup coin wallet user
                // updateWalletUser($walletHistory->coin_type, $walletHistory->coin_count, $walletHistory->user_id);
                break;
            default:
                //
                break;
        }
        return response('Giao dich xu ly thanh cong', 200);
    }
}
