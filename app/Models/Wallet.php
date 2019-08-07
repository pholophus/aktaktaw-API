<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $guarded = [
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
