<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RandomAccount extends Model
{
    protected $table = 'random_accounts';

    protected $fillable = [
        'random_id',
        'username',
        'password',
        'status',
        'author_id',
        'code'
    ];

    public function random()
    {
        return $this->belongsTo(Random::class);
    }
}
