<?php

namespace App\Transformer\Star;

class StarTransformer
{
    public static function forDatatable($items)
    {
        if (!$items || count($items) == 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $tmp = [
                'id' => $item->id,
                'user' => isset($item->user) ? $item->user : []
            ];
            array_push($result, $tmp);
        }
        return $result;
    }
}
