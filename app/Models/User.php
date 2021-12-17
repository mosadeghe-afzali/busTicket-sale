<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ger roles for users.
     *
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * get company associated to user.
     *
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * get reservations of the user.
     *
     */
    public function reservatons()
    {
        return $this->hasMany(Reservation::class);
    }
}
