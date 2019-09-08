<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserExpertise extends Base
{
    protected $table = 'user_expertise';

    protected $fillable = [
        'user_id',
        'expertise_id'
    ];

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function type(){
    //     return $this->belongsTo(Type::class);
    // }
}
