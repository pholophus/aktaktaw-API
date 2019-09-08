<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Base
{
    protected $table = 'bookings';
    protected $guard_name = 'api';

    protected $fillable = [
        'origin','booking_date','booking_time','end_call','notes','language','translator_id','origin_id','expertise_id','type_id','status_id'  
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'booking_user','booking_id', 'user_id');
    }
    // public function type()
    // {
    //     return $this->belongsTo(Type::class, 'type_id', 'id');
    // }
    public function expertise()
    {
        return $this->belongsTo(Expertise::class, 'expertise_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }
    // public function notification()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    //statuses


}
