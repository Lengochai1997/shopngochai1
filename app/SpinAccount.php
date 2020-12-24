<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpinAccount extends Model
{
    protected $table = 'spin_accounts';
    protected $fillable = [
        'spin_id',
        'type_id',
        'username',
        'password',
        'status'
    ];
}
