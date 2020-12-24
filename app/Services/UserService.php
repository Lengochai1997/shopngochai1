<?php

namespace App\Services;
use App\User;
use Auth;

class UserService {

    public static function changeTotalMoney($user_id, $value)
    {
        $user = User::find($user_id);
        return $user->update([
            'total_money' => $value
        ]);
    }

    public static function plusMoney($user_id, $value)
    {
        $user = User::find($user_id);
        return $user->update([
            'total_money' => $user->total_money + $value
        ]);
    }

    public static function minusMoney($user_id, $value)
    {
        $user = User::find($user_id);
        return $user->update([
            'total_money' => $user->total_money - $value
        ]);
    }
}
