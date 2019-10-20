<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Base
{
    protected $table = 'investors';

    protected $fillable = [
        'value','quantity','fromWhere','investment',
    ];

    public function investor(){
        return $this->belongsTo(Investor::class,'investor_Investor','Investor_id','investor_id')->withTimestamps();
    }
}
