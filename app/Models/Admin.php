<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $fillable = [
        'name',
        'username',
        'password',
        'is_super',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
