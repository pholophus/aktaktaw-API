<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Base
{
    protected $table = 'bookings';
    protected $guard_name = 'api';

    protected $fillable = [
        'origin', 'booking_date', 'booking_time', 'end_call', 'notes', 'language'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // public function type()
    // {
    //     return $this->belongsTo(Type::class, 'type_id', 'id');
    // }
    public function expertise()
    {
        return $this->belongsTo(Expertise::class, 'expertise_id', 'id');
    }
    // public function notification()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    //statuses


}
