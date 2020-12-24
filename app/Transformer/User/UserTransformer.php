<?php

namespace App\Transformer\User;

class UserTransformer {
    public static function forDataTable($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $temp = [
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username,
                'email' => $item->email,
                'total_money' => $item->total_money,
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
