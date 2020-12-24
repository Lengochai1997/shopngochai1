<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualHistory extends Model
{
    protected $table = 'virtual_histories';

    protected $fillable = [
        'id',
        'type',
        'ref_id',
        'name',
        'result',
        'time'
    ];
}
