<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'role', 'education', 'description'
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

    /*
     * Ein User kann mehrere Angebote veröffentlichen
     */
    public function offers() : HasMany {
        return $this->hasMany(Offer::class);
    }

    /*
     * Ein User kann mehreren Terminen zusagen
     */
    public function appointments() : HasMany {
        return $this->hasMany(Appointment::class);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function  getJWTCustomClaims()
    {
        return ['user'=>['id'=>$this->id,
                'role'=>$this->role,
                'name'=>$this->name,
                'education'=>$this->education,
                'email'=>$this->email,
                'description'=>$this->description]];
    }
}
