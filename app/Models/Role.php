<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    protected $fillable = [
        'uuid',
        'name',
        'guard_name',
        'slug',
        'code',
        'name_display',
    ];

    protected $guard_name = 'api';
}
