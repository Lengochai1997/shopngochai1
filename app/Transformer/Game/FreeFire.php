<?php

namespace App\Transformer;

use App\Services\UploadFile;
use Auth;

class FreeFire {
    static function forDatabase($account)
    {
        if (!$account || count($account) === 0) {
            return [];
        }
        $result = [];
        // info general
        if (array_key_exists('username', $account)) {
            $result['username'] = $account['username'];
        }
        if (array_key_exists('password', $account)) {
            $result['password'] = $account['password'];
        }
        if (array_key_exists('price', $account)) {
            $result['price'] = strval($account['price']);
        }
        if (array_key_exists('description', $account)) {
            $result['description'] = $account['description'];
        }
        // category_id
        if (array_key_exists('category_id', $account)) {
            $result['category_id'] = $account['category_id'];
        }
        // type_id
        if (array_key_exists('type_id', $account)) {
            $result['type_id'] = $account['type_id'];
        }
        // data
        $data = [];
        if (array_key_exists('rank', $account)) {
            $data['rank'] = $account['rank'];
        } else {
            $data['rank'] = '';
        }
        if (array_key_exists('pet', $account)) {
            $data['pet'] = $account['pet'];
        } else {
            $data['pet'] = '';
        }
        if (array_key_exists('register', $account)) {
            $data['register'] = $account['register'];
        } else {
            $data['register'] = '';
        }

        if (array_key_exists('code', $account)) {
            $data['code'] = $account['code'];
        } else {
            $data['code'] = '';
        }

        $result['data'] = json_encode($data);

        // image
        $result['images'] = isset($account['images']) ? json_encode($account['images']) : '';

        // thumbnail
        $result['thumbnail'] = $account['thumbnail'];

        // description
        $result['description'] = $account['description'];

        $admin = Auth::guard('admin')->user();
        if (!$admin->is_super == 1) {
            // is normal admin ==> author = admin id
            $result['author_id'] = $admin->id;
        } else {
            // is super admin ==> author = 0
            $result['author_id'] = 0;
        }
        return $result;
    }

    static function forEdit($item)
    {
        // data info account
        if (count(json_decode($item['data'], true)) > 0) {
            $data = json_decode($item['data'], true);
            $item['rank'] = $data['rank'];
            $item['pet'] = $data['pet'];
            $item['register'] = $data['register'];
            $item['code'] = $data['code'];
        }
        // data images
        $item['images'] = processImagesAccount($item['images']);

        return $item;
    }
}
