<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpinCoin extends Model
{
    protected $table = 'spin_coins';

    protected $fillable = [
        'type',
        'title',
        'properties',
        'ratio',
        'price',
        'thumbnail',
        'image',
        'rules',
        'description',
        'total',
        'count_turn',
        'pro_total',
        'status',
    ];

    public function history_total()
    {
        return $this->hasMany(HistorySpinCoinTotal::class, 'spin_coin_id', 'id');
    }
}
