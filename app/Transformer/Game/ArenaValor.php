<?php

namespace App\Transformer\Game;

use App\Services\ImgurService;
use App\Services\UploadFile;
use Auth;

class ArenaValor {
    static function forDatabase($account) {
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
        if (array_key_exists('count_hero', $account)) {
            $data['count_hero'] = $account['count_hero'];
        } else {
            $data['count_hero'] = 0;
        }
        if (array_key_exists('count_skin', $account)) {
            $data['count_skin'] = $account['count_skin'];
        } else {
            $data['count_skin'] = 0;
        }
        if (array_key_exists('gem_level', $account)) {
            $data['gem_level'] = $account['gem_level'];
        } else {
            $data['gem_level'] = 0;
        }
        if (array_key_exists('rank', $account)) {
            $data['rank'] = $account['rank'];
        } else {
            $data['rank'] = 0;
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
        // data account
        if (count(json_decode($item['data'], true)) > 0) {
            $data = json_decode($item['data'], true);
            $item['count_hero']  = strval($data['count_hero']);
            $item['count_skin']  = strval($data['count_skin']);
            $item['gem_level']   = strval($data['gem_level']);
            $item['rank']        = strval($data['rank']);
        }
        // data images
        $item['images'] = processImagesAccount($item['images']);
        return $item;
    }
}
