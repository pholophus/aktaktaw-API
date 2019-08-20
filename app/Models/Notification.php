<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Base
{
    protected $table = "notifications";

    protected $fillable = [
        'title',
        'description',
        'booking_id',
        'user_id'
    ];
    protected $searchable = [
        'columns' => [
            'notifications.title' => 10,
            'notifications.type' => 8,
        ],
    ];
    
    public function booking()
    {
        return $this->belongsTo(App\Models\Booking::class, 'booking_id', 'id');
    }

    // public function assignor()
    // {
    //     return $this->belongsTo('App\Models\User', 'assignor_id', 'id');
    // }
}
