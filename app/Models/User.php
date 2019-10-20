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
            'profiles.name' => 10,
        ],
        'joins' => [
            'profiles' => ['users.id','profiles.user_id'],
        ],
    ];
    protected $fillable = [
        'email', 'password','social_google_id','social_facebook_id','user_id','user_status','translator_status','booked', 'country'
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

    // public function userlanguages(){
    //     return $this->hasMany(LanguageUser::class);
    //  }
    // public function userexpertises(){
    //     return $this->hasMany(ExpertiseUser::class);
    // }
    public function languages(){
        return $this->belongsToMany(Language::class,'language_user','user_id','language_id')->withPivot('language_type')->withTimestamps();
    }
    public function expertises(){
        return $this->belongsToMany(Expertise::class,'expertise_user','user_id','expertise_id')->withTimestamps();
    }
    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class, 'user_id', 'id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class,'origin_id','id');
    }
    // public function roles(){
    //     return $this->belongsToMany(Role::class,'model_has_roles','model_id','role_id');
    // }
    // public function expertise(){
    //     return $this->belongsToMany(Expertise::class,'user_expertises','user_id', 'expertise_id');
    // }
    // public function roles(){
    //     return $this->belongsToMany(Role::class);
    // }
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }
    
    public function media(){
        return $this->hasMany(Media::class,'user_id','id');
    }

}
