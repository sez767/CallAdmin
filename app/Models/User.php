<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'social_network',
        'status',
        'country',
        'city',
        'avatar',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['nick'];

    public function getNickAttribute()
    {
        return $this->attributes['nick'] = ($this->name ?? $this->email);
    }

    /**
     * relations
     */

    public function roles()
    {
        return $this->hasMany(\App\Models\UserRole::class);
    }

    public function hasVerifiedEmail()
    {
        return $this->status;
    }
}
