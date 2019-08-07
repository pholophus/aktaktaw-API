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
            'users.email' => 8,
        ],
    ];
    protected $fillable = [
        'email', 'password','social_google_id','social_facebook_id','account_balance','user_id'
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
    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class, 'user_id', 'id');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    public function role(){
        return $this->belongsToMany(Role::class);
    }
    public function expertise(){
        return $this->belongsToMany(Expertise::class);
    }
    // public function type(){
    //     return $this->belongsToMany(Type::class);
    // }
}
