<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $table = 'gifts';

    protected $fillable = [
        'type',
        'title',
        'image',
        'price',
        'boxes',
        'sold',
        'message',
        'ratio',
        'category',
        'description',
        'status',
    ];

}
