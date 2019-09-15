<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'file_name','type','folder','path','mime_type','user_id'
    ];

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

}
