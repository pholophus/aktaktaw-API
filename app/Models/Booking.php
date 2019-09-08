<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Base
{
    protected $table = 'bookings';
    protected $guard_name = 'api';

    protected $fillable = [
       // 'origin',
        'booking_date',
        'booking_time',
        'booking_type',
        'booking_status',
        'call_duration',
        'end_call',
        'notes',
        'language',
        'booking_fee',
        'translator_id',
        'origin_id',
        'expertise_id',
        'requester_id',
        'language_id'  
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'origin_id', 'id');
    }
    // public function scopeGeneralUser()
    // {
    //     return $this->user()->with('roles')->role('general_user');
    // }
    // public function scopeTranslator()
    // {
    //     return $this->user()->with('roles')->role('translator');
    // }
    // public function language()
    // {
    //     return $this->belongsTo(Language::class, 'language_id', 'id');
    // }
    public function expertise()
    {
        return $this->belongsTo(Expertise::class,'expertise_id','id');
    }
    public function notification()
    {
        return $this->hasMany(Notification::class);
    }

    //statuses


}
