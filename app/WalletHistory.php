<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $table = 'wallet_histories';

    protected $fillable = [
        'user_id',
        'coin_type',
        'coin_count',
        'data',
        'status',
        'key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
