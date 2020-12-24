<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'thumbnail',
        'username',
        'password',
        'price',
        'description',
        'data',
        'images',
        'category_id',
        'type_id',
        'status',
        'author_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
