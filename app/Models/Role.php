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

    public function user(){
        return $this->belongsToMany(User::class,'model_has_roles','role_id', 'model_id');
    }
}
