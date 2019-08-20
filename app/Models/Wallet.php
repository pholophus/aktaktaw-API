<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'user_id','amount','type','status'
    ];

    public function user(){
        return $this->hasOne(\App\Models\User::class,'user_id','id');
    }


    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

}
