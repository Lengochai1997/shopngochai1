<?php

namespace App\Transformer\Wallet;

class WalletTransformer
{
    public static function forDataTables($items)
    {
        if (!$items || count($items) == 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $data = json_decode($item->data, true);
            if (array_key_exists('id', $data)) {
                $newData = $data['id'];
            }
            if (array_key_exists('username', $data)) {
                $newData = $data['username'];
            }
            $temp = [
                'created' => $item->created_at->format('H:i:s d-m-Y'),
                'type' => config('coin.type')[$item->coin_type],
                'value' => $item->coin_count,
                'status' => config('coin.status')[$item->status],
                'data' => $newData
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function forDashboard($items)
    {
        if (!$items || count($items) == 0) {
            return [];
        }
        $result = [];
        foreach ($items as $item) {
            $temp = [
                'id' => $item->id,
                'created' => $item->created_at->format('H:i:s d-m-Y'),
                'user' => $item->user ? $item->user : null,
                'type' => config('coin.type')[$item->coin_type],
                'value' => $item->coin_count,
                'data' => json_decode($item->data, true),
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
