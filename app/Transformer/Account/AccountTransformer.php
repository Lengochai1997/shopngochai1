<?php

namespace App\Transformer\Account;

use App\Category;

class AccountTransformer {

    static public function forDataTable($accounts)
    {
        if (!$accounts && count($accounts) === 0) {
        return [];
    }
        $result = [];
        foreach ($accounts as $account) {
            $temp = [
                'id' => $account->id,
                'username' => $account->username,
                'password' => $account->password,
                'price' => $account->price,
                'data' => json_decode($account->data, true),
                'category' => ($account->category !== null) ? $account->category->title : '',
                'type' => config('account.type')[$account->type_id],
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    static public function forEdit($account)
    {
        // data account
        if (count(json_decode($account['data'], true)) > 0) {
            $data = json_decode($account['data'], true);
            $account['count_hero']  = strval($data['count_hero']);
            $account['count_skin']  = strval($data['count_skin']);
            $account['gem_level']   = strval($data['gem_level']);
            $account['rank']        = strval($data['rank']);
        }
        // images account
        // TODO: Xử lý upload image
        if (count(json_decode($account['images'], true)) > 0) {
            $images = json_decode($account['images'], true);
            $account['images_des'] = isset($images['images_des']) ? $images['images_des'] : [];
            $account['images_hero'] = isset($images['images_hero']) ? $images['images_hero'] : [];
            $account['images_skin'] = isset($images['images_skin']) ? $images['images_skin'] : [];
        }
        return $account;
    }
}
