<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExpertiseUser extends Base
{
    protected $table = 'expertise_user';

    protected $fillable = [
        'user_id',
        'expertise_id'
    ];

}
