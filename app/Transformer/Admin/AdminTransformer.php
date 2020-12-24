<?php

namespace App\Transformer\Admin;

use App\Account;
use App\RandomAccount;

class AdminTransformer {

    static public function forDataTable($items)
    {
        if (!$items && count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $accounts = Account::where('author_id', $item->id)->where('status', 1)->get();
            $random_accounts = RandomAccount::join('randoms', 'random_accounts.random_id', 'randoms.id')
                ->select('random_accounts.*', 'randoms.price')
                ->where('author_id', $item->id)->where('random_accounts.status', 2)->get();

            $temp = [
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username,
                'type' => ($item->is_super == 1) ? "Super admin" : "Cộng tác viên",
                'count_account' => count($accounts),
                'count_random_account' => count($random_accounts),
                'income' => $item->income,
            ];
            array_push($result, $temp);
        }
        return $result;
    }



    static public function forInsert($item)
    {
        if (!$item) return null;
        return [
            'name' => $item['name'],
            'username' => $item['username'],
            'password' => bcrypt($item['password']),
            'is_super' => isset($item['is_super']) && $item['is_super'] == 1,
            'description' => ''
        ];
    }

    static public function forEdit($item)
    {
        if (!$item) return null;
        $item = $item->toArray();
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'username' => $item['username'],
            'is_super' => $item['is_super']
        ];
    }

}
