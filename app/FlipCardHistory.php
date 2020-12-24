<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlipCardHistory extends Model
{
    protected $table = 'flip_card_histories';

    protected $fillable = [
        'user_id',
        'flip_card_id',
        'flip_card_title',
        'flip_card_price',
        'result',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
