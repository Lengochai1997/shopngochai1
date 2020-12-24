<?php

namespace App\Transformer\Spin;

use App\Services\UploadFile;

class SpinTransformer {
    static public function forDatabase($spin)
    {
        $result = [];
        $properties = [];
        $i = 1;
        foreach ($spin as $key => $value) {
            if (strpos($key, 'key') !== false) {
                $properties[$i] = $value;
                $i++;
            }
        }
        $result['properties'] = json_encode($properties);
        $ratios = [];
        $i = 1;
        foreach ($spin as $key => $value) {
            if (strpos($key, 'ratio') !== false) {
                $ratios[$i] = $value;
                $i++;
            }
        }
        $result['ratio'] = json_encode($ratios);
        $result['price'] = $spin['price'];
        $result['title'] = $spin['title'];
        $result['total'] = $spin['total'];
        $result['status'] = $spin['status'];
        $result['pro_total'] = $spin['pro_total'];

        if (array_key_exists('pro_special', $spin)) {
            $result['pro_special'] = $spin['pro_special'];
        }

        if (array_key_exists('special_type', $spin)) {
            $result['special_type'] = $spin['special_type'];
        }

        if (array_key_exists('special_value', $spin)) {
            $result['special_value'] = $spin['special_value'];
        }

        if (array_key_exists('type', $spin)) {
            $result['type'] = $spin['type'];
        }

        $result['description'] = $spin['description'];
        $result['rules'] = $spin['rules'];

        if (array_key_exists('image', $spin)) {
            $result['image'] = UploadFile::uploadFromPublic($spin['image'], 'images');
        }
        if (array_key_exists('thumbnail', $spin)) {
            $result['thumbnail'] = UploadFile::uploadFromPublic($spin['thumbnail'], 'images');
        }

        return $result;
    }

    static public function forForm($spin)
    {
        $properties = json_decode($spin->properties, true);
        $spin->properties = $properties;
        $ratios = json_decode($spin->ratio, true);
        $spin->ratio = $ratios;
        return $spin;
    }

    static public function forDataTables($spins)
    {
        if (!$spins || count($spins) === 0) {
            return [];
        }
        $result = [];
        foreach ($spins as $spin) {
            $temp = [
                'id'    => $spin->id,
                'price' => $spin->price,
                'total' => $spin->total,
                'title' => $spin->title
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
