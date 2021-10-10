<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $fillable=[
        'sale_id',
        'branch_id',
        'user_id',
        'attribute_id',
        'quantity',
        'buying_price',
        'selling_price',
        'buy_total',
        'sell_total',
        'margin',
        'reversed',
    ];
    use HasFactory;

    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }

    public function sale(){
        return $this->belongsTo('App\Models\Sale');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
