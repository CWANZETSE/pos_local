<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
    use HasFactory;

    public CONST IS_REVERSED=1;
    public CONST IS_NOT_REVERSED=0;

    protected $fillable=[
        "ResultCode",
        "TransactionAmount",
        "CashBackAmt",
        "authCode",
        "msg",
        "rrn",
        "respCode",
        "cardExpiry",
        "currency",
        "pan",
        "tid",
        "transType",
        "payDetails",
        "user_id",
        "branch_id",
        "sale_id",
        "reversed",

    ];

    public function sale(){
    	return $this->belongsTo('App\Models\Sale');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
