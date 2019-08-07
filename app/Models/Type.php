<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $guarded = [
    ];

    public function UserLanguage(){
        return $this->hasMany(UserLanguage::class);
    }
}
