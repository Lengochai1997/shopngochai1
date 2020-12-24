<?php

namespace App\Transformer\Random;

use Illuminate\Support\Facades\DB;

class AccountTransformer {
    static public function forDatabase($item)
    {

    }

    static public function forForm($item)
    {

    }

    static public function forDataTables($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        $status = config('random.account_status');
        foreach ($items as $item) {
            $temp = [
                'id'        => $item->id,
                'username'  => $item->username ? $item->username : '',
                'password'  => $item->password ? $item->password : '',
                'status'    => isset($status[$item->status]) ? $status[$item->status] : '',
                'code'      => isset($item->code) ? $item->code : '',
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
