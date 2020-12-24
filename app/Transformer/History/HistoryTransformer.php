<?php

namespace App\Transformer\History;

class HistoryTransformer {

    public static function Account($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $account = $item->account;
            $user = $item->user;
            $temp = [
                'id' => $item->id,
                'user' => isset($user) ? $user : null,
                'created' => $item->created_at,
                'user_id' => $item->user_id,
                'account' => [
                    'id' => isset($account->id) ? $account->id : '',
                    'username' => isset($account->username) ? $account->username : '',
                    'password' => isset($account->password) ? $account->password : '',
                    'price' => isset($account->price) ? $account->price : 0,
                    'code' => isset($account->data) ? isset(json_decode($account->data)->code) ? json_decode($account->data)->code : '' : '',
                ],
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function forAdmin($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $user = $item->user;
            $account = $item->account;
            $temp = [
                'id' => $item->id,
                'created' => $item->created_at,
                'user' => isset($user) ? $user : '',
                'user_name' => isset($user->name) ? $user->name : $user->username,
                'account' => [
                    'username' => isset($account->username) ? $account->username : '',
                    'password' => isset($account->password) ? $account->password : '',
                    'price' => isset($account->price) ? $account->price : 0,
                ]
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function Random($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $account = $item->account;
            $random = $item->random;
            $user = $item->user;
            $temp = [
                'id' => $item->id,
                'user' => $user ? $user : null,
                'created' => $item->created_at,
                'account' => [
                    'id'       => isset($account->id) ? $account->id : '',
                    'username' => isset($account->username) ? $account->username : '',
                    'password' => isset($account->password) ? $account->password : '',
                    'code'     => isset($account->code) ? $account->code : '',
                ],
                'random' => isset($random->title) ? $random->title : '',
                'price' => isset($random->price) ? $random->price : 0
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function Spin($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $account = $item->account;
            $user = $item->user;
            $temp = [
                'id' => $item->id,
                'user' => isset($user) ? $user : null,
                'created' => $item->created_at,
                'account' => [
                    'username' => isset($account->username) ? $account->username : '',
                    'password' => isset($account->password) ? $account->password : '',
                ],
                'result' => $item->result,
                'price' => isset($item->spin->price) ? $item->spin->price : ''
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function SpinCoin($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $temp = [
                'created_at' => $item->created_at,
                'spin' => isset($item->spinCoin) ? $item->spinCoin : null,
                'user' => isset($item->user) ? $item->user : null,
                'result' => $item->result,
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function Wallet($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $temp = [
                'created' => $item->created_at,
                'user' => isset($item->user) ? $item->user : null,
                'coin_type' => config('coin.type')[$item->coin_type],
                'coin_count' => $item->coin_count,
                'data' => implode('|', json_decode($item->data, true)),
                'status' => config('coin.status')[$item->status],
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function Box($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $user = $item->user;
            $gift = $item->box->gift;
            $temp = [
                'created' => $item->created_at,
                'user' => isset($user) ? $user->toArray() : null,
                'gift' => [
                    'type' => isset($gift->type) ? config('coin.type')[$gift->type] : '',
                    'title' => isset($gift->title) ? $gift->title : '',
                    'price' => isset($gift->price) ? $gift->price : 0,
                ],
                'value' => isset($item->box->value),
                'status' => config('box.status')[$item->box->status]
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function SlotMachine($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $user = $item->user;
            $temp = [
                'created' => $item->created_at,
                'user' => $user ? $user : null,
                'slot_machine_title' => $item->slot_machine_title,
                'slot_machine_price' => $item->slot_machine_price,
                'result' => $item->result,
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function FlipCard($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $user = $item->user;
            $temp = [
                'created' => $item->created_at,
                'user' => $user ? $user : null,
                'flip_card_title' => $item->flip_card_title,
                'flip_card_price' => $item->flip_card_price,
                'result' => $item->result,
            ];
            array_push($result, $temp);
        }
        return $result;
    }

}
