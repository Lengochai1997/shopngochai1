<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySpinTotal extends Model
{
    protected $table = 'history_spin_totals';

    protected $fillable = [
        'user_id',
        'spin_id',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function spin()
    {
        return $this->belongsTo(Spin::class);
    }
}
