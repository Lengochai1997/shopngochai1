<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Random extends Model
{
    protected $table = 'randoms';

    protected $fillable = [
        'title',
        'thumbnail',
        'price',
        'description',
        'count_account',
        'count_selled',
        'alert',
        'status'
    ];
}
