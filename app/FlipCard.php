<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlipCard extends Model
{
    protected $table = 'flip_cards';

    protected $fillable = [
        'type',
        'image',
        'title',
        'url',
        'slots',
        'price',
        'rules',
        'description',
        'status'
    ];

    public function histories()
    {
        return $this->hasMany(FlipCardHistory::class, 'flip_card_id', 'id');
    }
}
