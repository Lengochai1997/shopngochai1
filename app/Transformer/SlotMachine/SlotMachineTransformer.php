<?php

namespace App\Transformer\SlotMachine;

class SlotMachineTransformer
{
    public static function forInsert($item)
    {
        if (isset($item['slots']) && count($item['slots']) > 0) {
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
        } else {
            $item['slots'] = '';
        }
        $item['model'] = isset($item['model']) ? $item['model'] : 'normal';
        $item['background'] = isset($item['background']) ? $item['background'] : '';
        return $item;
    }

    public static function forDataTable($items)
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
                'model' => $item->model ? $item->model : 'normal',
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    public static function forEdit($item)
    {
        if (!$item) return null;
        $item->slots = json_decode($item->slots, true);
        return $item;
    }

    public static function forShow($item)
    {
        if (!$item) return null;
        $item->price = number_format($item->price);
        $item->slots = json_decode($item->slots);
        return $item;
    }
}
