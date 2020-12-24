<?php

namespace App\Transformer\Random;

use App\Services\UploadFile;

class RandomTransformer {
    public static function forDatabase($item)
    {
        if (!$item) {
            return [];
        }
        $result = [];
        if (array_key_exists('title', $item)) {
            $result['title'] = $item['title'];
        }
        if (array_key_exists('count_account', $item)) {
            $result['count_account'] = $item['count_account'];
        }
        if (array_key_exists('price', $item)) {
            $result['price'] = $item['price'];
        }
        if (array_key_exists('count_selled', $item)) {
            $result['count_selled'] = $item['count_selled'];
        }
        if (array_key_exists('status', $item)) {
            $result['status'] = $item['status'];
        }
        if (array_key_exists('alert', $item)) {
            $result['alert'] = $item['alert'];
        }
        if (array_key_exists('description', $item)) {
            $result['description'] = $item['description'];
        }
        if (array_key_exists('thumbnail', $item)) {
            $result['thumbnail'] = UploadFile::uploadFromPublic($item['thumbnail'], 'images');
        }
        return $result;
    }

    public static function forDataTables($items)
    {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item)
        {
            $temp = [
                'id' => $item->id,
                'title' => $item->title,
                'price' => $item->price,
                'count_account' => $item->count_account,
                'count_selled' => $item->count_selled,
                'status' => config('random.status')[$item->status]
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
