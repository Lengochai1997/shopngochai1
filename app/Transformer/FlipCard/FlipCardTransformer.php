<?php

namespace App\Transformer\FlipCard;

class FlipCardTransformer
{
    public function __construct()
    {

    }

    public function forDataTable($items)
    {
        if (!$items) return [];
        $result = [];
        foreach ($items as $item) {
            $temp = [
                'id' => $item->id,
                'title' => $item->title,
                'url' => $item->url,
                'type' => config('coin.type')[$item->type],
                'price' => $item->price,
                'status' => config('slot_machine.status')[$item->status],
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public function forInsert($item)
    {
        if (count($item['slots']) > 0) {
            $slots = [];

            $slot = $item['slots'];
            $title = $item['titles'];
            $coin = $item['coins'];
            $value = $item['values'];

            unset($item['slots']);
            unset($item['titles']);
            unset($item['coins']);
            unset($item['values']);

            for ($i = 0; $i < count($slot); $i++) {
                array_push($slots, [
                    'img' => $slot[$i],
                    'title' => $title[$i],
                    'coin' => $coin[$i],
                    'value' => $value[$i],
                ]);
            }
            $item['slots'] = json_encode($slots);
        }
        return $item;
    }

    public function forEdit($item)
    {
        if (!$item) return null;
        $item->slots = json_decode($item->slots, true);
        return $item;
    }

    public function forShow($item)
    {
        if (!$item) return null;
        $item = $item->toArray();
        $item['price'] = number_format($item['price']);
        $item['slots'] = json_decode($item['slots'], true);
        shuffle($item['slots']);
        return $item;
    }

}
