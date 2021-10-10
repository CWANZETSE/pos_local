<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable=[
      'branch_id',
      'category_id',
      'product_id',
      'size_id',
      'amount',
      'expiry_date',
      'admin_id',
    ];

    public function branch(){
        return $this->belongsTo('\App\Models\Branch');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product');
    }
    public function size(){
        return $this->belongsTo('\App\Models\Size');
    }
}
