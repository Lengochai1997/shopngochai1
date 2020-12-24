<?php

namespace App\Http\Controllers\History;

use App\FlipCardHistory;
use App\HistoryAccount;
use App\HistoryBox;
use App\HistoryRandom;
use App\HistorySlotMachine;
use App\HistorySpin;
use App\HistorySpinCoin;
use App\Http\Controllers\Controller;
use App\Transformer\History\HistoryTransformer;
use App\WalletHistory;
use Illuminate\Http\Request;
use DB;

class HistoryController extends Controller
{
    private $historyAccount;
    private $historyRandom;
    private $historySpin;
    private $historySpinCoin;
    private $walletHistory;
    private $historyBox;
    private $historySlotMachine;
    private $flipCardHistory;

    public function __construct(HistoryAccount $historyAccount,
                                HistoryRandom $historyRandom,
                                HistorySpin $historySpin,
                                HistorySpinCoin $historySpinCoin,
                                WalletHistory $walletHistory,
                                HistoryBox $historyBox,
                                HistorySlotMachine $historySlotMachine,
                                FlipCardHistory $flipCardHistory)
    {
        $this->historyAccount = $historyAccount;
        $this->historyRandom = $historyRandom;
        $this->historySpin = $historySpin;
        $this->historySpinCoin = $historySpinCoin;
        $this->walletHistory = $walletHistory;
        $this->historyBox = $historyBox;
        $this->historySlotMachine = $historySlotMachine;
        $this->flipCardHistory = $flipCardHistory;
    }

    public function historyAccount(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $accounts = $this->historyAccount
                ->join('accounts', 'history_accounts.account_id', '=', 'accounts.id')
                ->join('users', 'history_accounts.user_id', '=', 'users.id')
                ->select('history_accounts.*')
                ->where('accounts.username', 'like', "%{$sSearch}%")
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_accounts.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $count = $this->historyAccount
                ->join('accounts', 'history_accounts.account_id', '=', 'accounts.id')
                ->join('users', 'history_accounts.user_id', '=', 'users.id')
                ->where('accounts.username', 'like', "%{$sSearch}%")
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->count();
            $data = HistoryTransformer::Account($accounts);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.history.account');

    }

    public function historyRandom(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $accounts = $this->historyRandom
                ->join('random_accounts', 'history_randoms.random_account_id', '=', 'random_accounts.id')
                ->join('users', 'history_randoms.user_id', '=', 'users.id')
                ->select('history_randoms.*')
                ->where('random_accounts.username', 'like', "%{$sSearch}%")
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_randoms.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $count = $this->historyRandom
                ->join('random_accounts', 'history_randoms.random_account_id', '=', 'random_accounts.id')
                ->join('users', 'history_randoms.user_id', '=', 'users.id')
                ->where('random_accounts.username', 'like', "%{$sSearch}%")
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->count();
            $data = HistoryTransformer::Random($accounts);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.history.random');
    }

    public function historySpin(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $accounts = $this->historySpin
                ->join('users', 'history_spins.user_id', '=', 'users.id')
                ->select('history_spins.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_spins.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $count = $this->historySpin
                ->join('users', 'history_spins.user_id', '=', 'users.id')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->count();
            $data = HistoryTransformer::Spin($accounts);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.history.spin');
    }

    public function historySpinCoin(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';

            $histories = $this->historySpinCoin
                ->join('users', 'history_spin_coins.user_id', '=', 'users.id')
                ->select('history_spin_coins.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_spin_coins.id', 'desc')
                ->offset($offset)->limit($limit)
                ->get();
            $count = $this->historySpinCoin
                ->join('users', 'history_spin_coins.user_id', '=', 'users.id')
                ->select('history_spin_coins.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_spin_coins.id', 'desc')
                ->count();

            $data = HistoryTransformer::SpinCoin($histories);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.history.spin_coin');
    }

    public function historyWallet(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $wallets = $this->walletHistory
                ->join('users', 'wallet_histories.user_id', '=', 'users.id')
                ->select('wallet_histories.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('wallet_histories.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $count = $this->walletHistory
                ->join('users', 'wallet_histories.user_id', '=', 'users.id')
                ->select('wallet_histories.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->count();
            $data = HistoryTransformer::Wallet($wallets);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.history.wallet');
    }

    public function historyBox(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $items = $this->historyBox
                ->join('users', 'history_box.user_id', '=', 'users.id')
                ->select('history_box.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_box.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $data = HistoryTransformer::Box($items);
            $countTable = $this->historyBox
                ->join('users', 'history_box.user_id', '=', 'users.id')
                ->select('history_box.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orderBy('history_box.id', 'desc')
                ->count();
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $countTable,
                'recordsFiltered' => $countTable,
                'data' => $data
            ], 200);
        }
        return view('admin.history.box');
    }

    public function historySlotMachine(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $items = $this->historySlotMachine
                ->join('users', 'history_slot_machines.user_id', '=', 'users.id')
                ->select('history_slot_machines.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orWhere('slot_machine_title', 'like', "%{$sSearch}%")
                ->Orwhere('slot_machine_price', 'like', "%{$sSearch}%")
                ->Orwhere('result', 'like', "%{$sSearch}%")
                ->orderBy('history_slot_machines.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $data = HistoryTransformer::SlotMachine($items);
            $countTable = $this->historySlotMachine
                ->where('slot_machine_title', 'like', "%{$sSearch}%")
                ->Orwhere('slot_machine_price', 'like', "%{$sSearch}%")
                ->Orwhere('result', 'like', "%{$sSearch}%")
                ->count();
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $countTable,
                'recordsFiltered' => $countTable,
                'data' => $data
            ], 200);
        }
        return view('admin.history.slot_machine');
    }

    public function historyFlipCard(Request $request)
    {
        if ($request->has('type') && $request->input('type') === 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
            $items = $this->flipCardHistory
                ->join('users', 'flip_card_histories.user_id', '=', 'users.id')
                ->select('flip_card_histories.*')
                ->orWhere('users.id', 'like', "%{$sSearch}%")
                ->orWhere('users.username', 'like', "%{$sSearch}%")
                ->orWhere('users.name', 'like', "%{$sSearch}%")
                ->orWhere('flip_card_title', 'like', "%{$sSearch}%")
                ->Orwhere('flip_card_price', 'like', "%{$sSearch}%")
                ->Orwhere('result', 'like', "%{$sSearch}%")
                ->orderBy('flip_card_histories.id', 'desc')
                ->offset($offset)->limit($limit)->get();
            $data = HistoryTransformer::FlipCard($items);
            $countTable = $this->flipCardHistory
                ->where('flip_card_title', 'like', "%{$sSearch}%")
                ->Orwhere('flip_card_price', 'like', "%{$sSearch}%")
                ->Orwhere('result', 'like', "%{$sSearch}%")
                ->count();
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $countTable,
                'recordsFiltered' => $countTable,
                'data' => $data
            ], 200);
        }
        return view('admin.history.flip_card');
    }

}
