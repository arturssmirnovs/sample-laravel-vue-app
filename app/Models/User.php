<?php

namespace App\Models;

use App\Traits\Has2FA;
use App\Traits\HasTeams;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Has2FA, HasTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'phone',
        'enabled_2fa',
        'gender_id',
        'timezone_id',
        'country_id',
        'language_id',
        'bio',
        'picture',
        'notifications',
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
        'notifications' => AsArrayObject::class
    ];

    public function providers()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }

    public function code()
    {
        return $this->hasOne(UserCode::class,'user_id','id');
    }
}
