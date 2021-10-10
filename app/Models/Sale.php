<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    CONST IS_REVERSED=1;
    CONST IS_NOT_REVERSED=0;

    protected $fillable=[
        'admin_id',
        'reversed_on',
        'tax_rate',
        'total_discount',
        'allow_reprint',
        'branch_id',
        'grand_total',
        'tendered',
        'change',
        'sale',
        'reversed_amount',
        'reversed',
        'margin',
        'mac_address',
        'ip_address',
        'canceled_by',
    ];

    public function branch(){
    	return $this->belongsTo('App\Models\Branch');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User');
    }

    public function salesReturn(){
        return $this->hasMany('App\Models\SalesReturn');
    }
    public function cashPayment(){
        return $this->hasOne('App\Models\CashPayment');
    }
    public function cardPayment(){
        return $this->hasOne('App\Models\CardPayment');
    }
    public function mpesaPayment(){
        return $this->hasOne('App\Models\MpesaPayment');
    }
}
