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
        'email', 'password','social_google_id','social_facebook_id','wallet_id','user_id'
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

    public function userlanguage(){
        return $this->hasMany(UserLanguage::class);
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
        return $this->belongsToMany(Role::class,'model_has_roles','model_id','role_id');
    }
    public function expertise(){
        return $this->belongsToMany(Expertise::class,'user_expertises','user_id', 'expertise_id');
    }
    // public function type(){
    //     return $this->belongsToMany(Type::class);
    // }

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }
    
    public function media(){
        return $this->hasMany(Media::class,'user_id','id');
    }

}
