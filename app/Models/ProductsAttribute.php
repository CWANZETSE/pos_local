<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock' ,
        'size',
        'size_id',
        'price',
        'sku',
        'product_id',
        'branch_id'
    ];

    public function product(){
    	return $this->belongsTo('\App\Models\Product');
    }
    public function size(){
        return $this->belongsTo('\App\Models\Size');
    }
    public function branch(){
    	return $this->belongsTo('\App\Models\Branch');
    }
}
