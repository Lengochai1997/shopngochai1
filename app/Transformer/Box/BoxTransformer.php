<?php

namespace App\Transformer\Box;

class BoxTransformer {
    static function forDatabase()
    {

    }

    static function forDataTables($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $tmp = [
                'id' => $item->id,
                'value' => $item->value,
                'status' => config('box.status')[$item['status']]
            ];
            array_push($result, $tmp);
        }
        return $result;
    }
}
