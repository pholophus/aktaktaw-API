<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    // protected $guarded = [
    // ];
    protected $fillable = [ 
        'name','category'
    ];

    public function languages(){
        return $this->hasMany(Language::class,'type_id','id');
    }
}
