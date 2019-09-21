<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Base
{
    protected $table = 'bookings';
    protected $guard_name = 'api';

    protected $fillable = [
       // 'origin',
        'start_call_at',
        'end_call_at',
        'type',
        'status',
        'notes',
        'language',
        // 'booking_fee',
        'translator_id',
        'origin_id',
        'expertise_id',
        'requester_id',
        'requested_language_id',
        'spoken_language_id'
    ];

    protected $dates = ['start_call_at', 'end_call_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'origin_id', 'id');
    }

    public function request_language()
    {
        return $this->belongsTo(Language::class, 'requested_language_id', 'id');
    }

    public function spoken_language()
    {
        return $this->belongsTo(Language::class, 'spoken_language_id', 'id');
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class,'expertise_id','id');
    }

    public function translator()
    {
        return $this->belongsTo(User::class, 'translator_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }


}
