<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const NO_PRINT_NO_DRAWER=0;
    public const YES_PRINT_YES_DRAWER=1;
    public const YES_PRINT_NO_DRAWER=2;
    public const NO_PRINT_YES_DRAWER=3;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'assigned_till',
        'branch_id',
        'username',
        'printer_ip',
        'printer_port',
        'last_login',
        'last_login_ip',
        'last_login_mac',
        'print_receipt',
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

    public function orders(){
        return $this->hasMany('\App\Models\Order');
    }
    public function shifts(){
        return $this->hasMany('\App\Models\Shift');
    }
    public function declarations(){
        return $this->hasMany('\App\Models\Declarations');
    }
    public function profile(){
        return $this->hasOne('\App\Models\Profile');
    }
    public function branch(){
        return $this->belongsTo('\App\Models\Branch');
    }
    public function sales(){
        return $this->hasMany('\App\Models\Sale');
    }
    public function cashPayments(){
        return $this->hasMany('\App\Models\CashPayment');
    }
    public function cardPayments(){
        return $this->hasMany('\App\Models\CardPayment');
    }

}
