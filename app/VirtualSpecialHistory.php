<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualSpecialHistory extends Model
{
    protected $table = 'virtual_special_histories';

    protected $fillable = [
        'id',
        'type',
        'ref_id',
        'name',
        'result',
        'time'
    ];
}
