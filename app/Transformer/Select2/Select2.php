<?php

namespace App\Transformer\Select2;

class Select2 {
    static function createForSelect2($items, $key = 'name') {
        if (!$items || count($items) === 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $result[$item['id']] = $item[$key];
        }
        return $result;
    }
}
