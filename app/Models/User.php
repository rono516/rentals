<?php

namespace App\Models;

use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGravatarAttribute()
    {
        return Gravatar::get($this->email);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }
}
