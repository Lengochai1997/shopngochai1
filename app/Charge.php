<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $table = 'charges';

    protected $fillable = [
        'user_id',
        'payment_id',
        'amount',
        'serial',
        'pin',
        'status',
        'tran_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
}
