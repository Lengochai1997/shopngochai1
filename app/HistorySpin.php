<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySpin extends Model
{
    protected $table = 'history_spins';
    protected $fillable = [
        'user_id',
        'spin_id',
        'spin_account_id',
        'result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(SpinAccount::class, 'spin_account_id', 'id');
    }

    public function spin()
    {
        return $this->belongsTo(Spin::class);
    }
}
