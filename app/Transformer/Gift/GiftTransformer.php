<?php

namespace App\Transformer\Gift;

use App\Services\UploadFile;
use Auth;

class GiftTransformer {
    static function forDatabase($item)
    {
        if (isset($item['image'])) {
            $item['image'] = UploadFile::uploadFromPublic($item['image'], 'images_del');
        }
        return $item;
    }

    static function forDataTable($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $item = $item->toArray();
            $item['type'] = config('coin.type')[$item['type']];
            array_push($result, $item);
        }
        return $result;
    }
}
