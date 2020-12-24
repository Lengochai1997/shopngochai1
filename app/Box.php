<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'boxes';

    protected $fillable = [
        'gift_id',
        'value',
        'status',
        'description'
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id', 'id');
    }
}
