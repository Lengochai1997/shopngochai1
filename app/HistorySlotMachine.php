<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySlotMachine extends Model
{
    protected $table = 'history_slot_machines';

    protected $fillable = [
        'user_id',
        'slot_machine_id',
        'slot_machine_title',
        'slot_machine_price',
        'result',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
