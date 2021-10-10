<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    const IS_PENDINGINVOICE=0;

    protected $fillable=[
        'branch_id',
        'supplier_id',
        'order_id',
        'payment_mode',
        'canceled',
        'canceled_by',
        'payment_status',
        'invoice_id',
        'order_data',
        'paid_on',
        'paid_by',
        'payment_id',
        'due_on',
        'account_number',
        'bank_name',
        'bank_transaction_id',
    ];

    public function branch(){
    	return $this->belongsTo('App\Models\Branch');
    }

    public function admin(){
    	return $this->belongsTo('App\Models\Admin');
    }

    public function supplier(){
    	return $this->belongsTo('App\Models\Supplier');
    }
    public function product(){
    	return $this->belongsTo('App\Models\Product');
    }
    public function size(){
    	return $this->belongsTo('App\Models\Size');
    }

}
