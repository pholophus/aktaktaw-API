<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Base
{
    protected $table = 'expertises';

    //this is to allow searching across models
    protected $searchable = [
        'columns' => [
            'expertises.name' => 10,
        ],
    ];

    protected $fillable = [
        'name','slug'
    ];

    public function user(){
        return $this->belongsToMany(User::class,'user_expertises','expertise_id', 'user_id');
    }
    public function booking()
    {
        return $this-hasOne(Booking::class);
    }
    
}
