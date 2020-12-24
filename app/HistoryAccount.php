<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryAccount extends Model
{
    protected $table = 'history_accounts';
    protected $fillable = [
        'user_id',
        'account_id'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }
}
