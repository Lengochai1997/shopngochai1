<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryRandom extends Model
{
    protected $table = 'history_randoms';
    protected $fillable = [
        'user_id',
        'random_id',
        'random_account_id',
        'result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(RandomAccount::class, 'random_account_id', 'id');
    }

    public function random()
    {
        return $this->belongsTo(Random::class);
    }
}
