<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryBox extends Model
{
    protected $table = 'history_box';

    protected $fillable = [
        'box_id',
        'user_id',
        'description'
    ];

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
