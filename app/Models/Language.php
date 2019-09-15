<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Base
{
    protected $table = 'languages';

    protected $guarded = [
        'id',
        'uuid'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'language_user','language_id','user_id')->withTimestamps();
    }

    // public function userlanguages(){
    //     return $this->hasMany(LanguageUser::class);
    //  }
}
