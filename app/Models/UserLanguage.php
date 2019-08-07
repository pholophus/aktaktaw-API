<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserLanguage extends Base
{
    protected $table = 'user_languages';

    protected $guarded = [
        'id',
        'uuid'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Type(){
        return $this->belongsTo(Type::class);
    }
}
