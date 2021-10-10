<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'status',
        'role_id',
        'branch_id',
        'last_login',
        'last_login_ip',
        'last_login_mac',
    ];

    const IS_ADMINISTRATOR =1;
    const IS_MANAGER =2;

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

    public function branch(){
        return $this->belongsTo('\App\Models\Branch');
    }
    public function purchases(){
        return $this->hasMany('\App\Models\Purchase');
    }

    public function salesReturn(){
        return $this->hasMany('\App\Models\SalesReturn');
    }
    public function declarations(){
        return $this->hasMany('\App\Models\Declaration');
    }
}
