<?php


namespace App\Transformer\VirtualHistory;


class VirtualHistoryTransformer
{
    public function forInsert($item)
    {
        if (!$item) return [];
        return [
            'type' => $item['type'],
            'ref_id' => $item['ref_id'],
            'name' => $item['name'],
            'result' => $item['result'],
            'time' => $item['time']
        ];
    }

    public function forDataTable($items)
    {
        if (!$items) {
            return [];
        }
        $result = [];
        $type = config('history_virtual.type');
        foreach ($items as $item) {
            $tmp = [
                'id' => $item->id,
                'type' => isset($type[$item->type]) ? $type[$item->type]: '',
                'name' => $item->name ? $item->name : '',
                'result' => $item->result ? $item->result : '',
                'time' => $item->time ? $item->time : ''
            ];
            array_push($result, $tmp);
        }
        return $result;
    }
}
