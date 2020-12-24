<?php

namespace App\Http\Controllers\Random;

use App\Admin;
use App\HistoryRandom;
use App\Http\Controllers\Controller;
use App\Random;
use App\RandomAccount;
use App\Services\UserService;
use Illuminate\Http\Request;
use Auth;

class AccountController extends Controller
{
    private $random;
    private $randomAccount;
    private $historyRandom;
    private $admin;

    public function __construct(Random $random, RandomAccount $randomAccount, HistoryRandom $historyRandom, Admin $admin)
    {
        $this->random = $random;
        $this->randomAccount = $randomAccount;
        $this->historyRandom = $historyRandom;
        $this->admin = $admin;
    }

    public function index(Request $request, $id)
    {
        $random = $this->random->find($id);
        $randomAccounts = $this->randomAccount->where('random_id', $id)->where('status', 0)->paginate(12);
        return view('random.index', compact('random', 'randomAccounts'));
    }

    public function buy(Request $request, $id)
    {
        $account = $this->randomAccount->find($id);
        $random = $account->random;
        return view('random.popup.buy_popup', compact('account', 'random'));
    }

    public function doBuy(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'message' => 'Thao tác không hợp lệ',
                'status' => 'error'
            ], 500);
        }
        // get info account random
        $account = $this->randomAccount->find($id);
        // check status account
        if ((int)$account->status == 2) {
            return response()->json([
                'message' => 'Thao tác không hợp lệ',
                'status' => 'error'
            ], 500);
        }
        // get info random
        $random = $account->random;
        // check total money user
        if (Auth::user()->total_money < $random->price) {
            return response()->json([
                'message' => 'Thao tác không hợp lệ',
                'status' => 'error'
            ], 500);
        }
        // add to history
        $result = $this->historyRandom->create([
            'user_id' => Auth::id(),
            'random_id'=> $random->id,
            'random_account_id' => $account->id,
        ]);
        // change status account
        $account->update([
            'status' => 2
        ]);
        // minus total_money
        UserService::minusMoney(Auth::id(), $random->price);
        // plus to count selled
        plusRandomSell($random->id);

        // update income admin
        if ($account->author_id != 0 || $account->author_id != '') {
            $admin = $this->admin->where('id', $account->author_id)->first();
            if ($admin) {
                $newIncome = $admin->income + $random->price;
                $admin->update([
                    'income' => $newIncome
                ]);
            }
        }

        return response()->json([
            'message' => 'Mua ' . $random->title . ' thành công.',
            'status' => 'success'
        ], 200);
    }

    public function showInfo($id)
    {
        $account = $this->randomAccount->find($id);
        return view('random.popup.info', compact('account'));
    }
}
