<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LanguageUser extends Base
{
    protected $table = 'language_user';

    protected $guarded = [
        'id',
        'uuid'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
