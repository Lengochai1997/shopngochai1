<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;

class WalletController extends Controller
{
    private $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function index()
    {
        $user = Auth::user();
    }

    public function withoutKimCuong()
    {
        $wallet = $this->wallet->where('user_id', Auth::id())->first();
        return view('user.without_kimcuong', compact('wallet'));
    }

    public function withoutQuanHuy()
    {
        $wallet = $this->wallet->where('user_id', Auth::id())->first();
        return view('user.without_quanhuy', compact('wallet'));
    }
}
