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

    public function users()
    {
        //return $this->belongsTo(User::class, 'origin_id', 'id');
        return $this->belongsToMany(User::class,'booking_user','booking_id', 'user_id');
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
        
    public function expertise()
    {
        return $this->belongsTo(Expertise::class,'expertise_id','id');
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }


}
