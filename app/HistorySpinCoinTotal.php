<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySpinCoinTotal extends Model
{
    protected $table = 'history_spin_coin_totals';

    protected $fillable = [
        'user_id',
        'spin_coin_id',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
