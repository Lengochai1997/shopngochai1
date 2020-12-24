<?php

namespace App\Transformer\Charge;

use App\Charge;

class ChargeTransformer {

    static public function forDataTable($charges)
    {
        if (!$charges && count($charges) === 0) {
            return [];
        }
        $result = [];
        foreach ($charges as $charge) {
            $temp = [
                'id'        => $charge->id,
                'create'    => $charge->created_at,
                'serial'    => $charge->serial,
                'pin'       => $charge->pin,
                'amount'    => number_format($charge->amount),
                'payment'   => $charge->payment->toArray(),
                'user'      => $charge->user->toArray(),
                'status'    => isset(config('charge.status')[$charge->status]) ? config('charge.status')[$charge->status] : config('charge.status')[1]
            ];
            array_push($result, $temp);
        }
        return $result;
    }
}
