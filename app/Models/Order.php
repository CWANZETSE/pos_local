<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const IS_PENDING=0;
    const IS_APPROVED=1;
    const IS_DECLINED=2;

    protected $fillable=[
        'order_id',
        'branch_id',
        'supplier_id',
        'order_data',
        'order_total',
        'status',
        'created_by',
        'canceled_by',
        'approved_by',
        'due_on',
        'paid_on',
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
