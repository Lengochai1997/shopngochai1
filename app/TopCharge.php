<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopCharge extends Model
{
    protected $table = 'top_charges';

    protected $fillable = [
        'user_id',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
