<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Base
{
    protected $table = 'profiles';

    //this is to allow searching across models
    protected $searchable = [
        'columns' => [
            'profiles.name' => 10,
            'profiles.phone' => 2,
        ],
    ];

    protected $fillable = [
        'name','phone_no','avatar_file_path','resume_file_path','user_id'
    ];


    public function user(){
        return $this->hasOne(\App\Models\User::class,'user_id','id');
    }
    
}
