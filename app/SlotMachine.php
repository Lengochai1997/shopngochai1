<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlotMachine extends Model
{
    protected $table = 'slot_machines';

    protected $fillable = [
        'id',
        'title',
        'slots',
        'type',
        'price',
        'description',
        'status',
        'url',
        'image',
        'model',
        'background'
    ];

    public function histories()
    {
        return $this->hasMany(HistorySlotMachine::class, 'slot_machine_id', 'id');
    }
}
