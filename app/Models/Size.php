<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'product_id',
        'status',
        'sku',
        'taxable',
        'reorder_level',
    ];

    public function product(){
    	return $this->belongsTo('App\Models\Product');
    }

    public function purchases(){
        return $this->hasMany('App\Models\Purchase');
    }
    public function discounts(){
        return $this->hasMany('\App\Models\Discount');
    }
    public function productsAttributes(){
        return $this->hasMany('\App\Models\ProductsAttribute');
    }
}
