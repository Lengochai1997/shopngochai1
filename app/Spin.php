<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    protected $table = 'spins';
    protected $fillable = [
        'title',
        'properties',
        'ratio',
        'price',
        'thumbnail',
        'image',
        'total',
        'status',
        'description',
        'rules',
        'total_turns',
        'pro_total',
        'pro_special',
        'special_type',
        'special_value'
    ];

    public function history_total()
    {
        return $this->hasMany(HistorySpinTotal::class, 'spin_id', 'id');
    }
}
