<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;
class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use SearchableTrait;

    protected $guard_name = 'api';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.nickname' => 8,
            'users.email' => 8,
            'users.phone_no' => 8,
        ],
    ];
    protected $fillable = [
        'name','nickname', 'email', 'password','phone_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserLanguage(){
        return $this->hasMany(User_Language::class);
    }

    public function Wallet(){
        return $this->hasOne(User_Language::class);
    }
}
