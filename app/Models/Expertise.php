<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Base
{
    protected $table = 'expertises';

    //this is to allow searching across models
    protected $searchable = [
        'columns' => [
            'expertises.expertise_name' => 10,
        ],
    ];

    protected $fillable = [
        'expertise_name','slug','expertise_status',
    ];

    // public function user(){
    //     return $this->belongsToMany(User::class,'user_expertises','expertise_id', 'user_id');
    // }
    // public function booking()
    // {
    //     return $this-hasOne(Booking::class);
    // }
    public function users(){
        return $this->belongsToMany(User::class,'expertise_user','expertise_id','user_id');
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function fees(){
        return $this->belongsToMany(Fee::class,'expertise_fee','expertise_id','fee_id');
    }
    
}
