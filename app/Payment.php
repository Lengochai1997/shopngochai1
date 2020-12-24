<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'gate_id',
        'title',
        'key',
        'order',
        'status',
        'description',
        'type_id',
        'percent',
    ];
}
