<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySpinCoin extends Model
{
    protected $table = 'history_spin_coins';

    protected $fillable = [
        'user_id',
        'spin_coin_id',
        'result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spinCoin()
    {
        return $this->belongsTo(SpinCoin::class);
    }
}
