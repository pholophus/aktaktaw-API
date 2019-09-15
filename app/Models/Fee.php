<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Base
{
    protected $table = 'fees';

    protected $fillable = [
        'fee_name','fee_duration','fee_rate','fee_status',
    ];

    public function expertises(){
        return $this->belongsToMany(Expertise::class,'expertise_fee','fee_id','expertise_id')->withTimestamps();
    }
}
