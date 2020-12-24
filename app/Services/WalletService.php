<?php

namespace App\Services;

use App\Wallet;

class WalletService
{

    // get info wallet
    public static function getWallet($user_id)
    {
        return Wallet::where('user_id', $user_id)->first();
    }

    // update kimcuong
    public static function updateKimCuong($user_id, $value)
    {
        $wallet = Wallet::where('user_id', $user_id)->first();
        $wallet->update([
            'kimcuong' => $value,
        ]);
        return true;
    }

    // update quanhuy
    public static function updateQuanHuy($user_id, $value)
    {
        $wallet = Wallet::where('user_id', $user_id)->first();
        $wallet->update([
            'quanhuy' => $value,
        ]);
        return true;
    }
}
