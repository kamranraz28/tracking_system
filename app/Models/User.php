<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'division_id',
        'district_id',
        'upazila_id',
        'name',
        'email',
        'password',
        'image',
        'officeid',
        'contact',
        'address',
        'level',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function asm()
    {
        return $this->hasOne(Asm::class, 'user_id');
    }
    public function tsm()
    {
        return $this->hasOne(Tsm::class, 'user_id');
    }
    public function dealer()
    {
        return $this->hasOne(Dealer::class, 'user_id');
    }
    public function sr()
    {
        return $this->hasOne(Sr::class, 'user_id');
    }
    public function retail()
    {
        return $this->hasOne(Retail::class, 'user_id');
    }

}
