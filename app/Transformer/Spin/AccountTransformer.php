<?php

namespace App\Transformer\Spin;

use Illuminate\Support\Facades\DB;

class AccountTransformer {
    static public function forDatabase($item)
    {

    }

    static public function forForm($item)
    {

    }

    static public function forCheckBuy($item)
    {
        if (!$item) {
            return null;
        }
        if (isset($item->data) && $item->data != '') {
            $item->data = json_decode($item->data);
        }
        return $item;
    }

    static public function forDataTables($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        $status = config('spin.status_account');
        foreach ($items as $item) {
            $temp = [
                'id'        => $item->id,
                'username'  => $item->username,
                'password'  => $item->password,
                'type_id'   => $item->type_id,
                'status'    => $status[$item->status]
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
