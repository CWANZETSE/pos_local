<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'name',
        'category_id',
        'status',
    ];
    use HasFactory;
    public function category(){
    	return $this->belongsTo('\App\Models\Category');
    }

    public function branch(){
        return $this->belongsTo('\App\Models\Branch');
    }

    public function attributes(){
    	return $this->hasMany('\App\Models\ProductsAttribute','product_id')->limit(5);
    }

    public function photos(){
        return $this->hasMany('\App\Models\Photo');
    }
    public function sizes(){
        return $this->hasMany('\App\Models\Size');
    }
    public function purchases(){
        return $this->hasMany('\App\Models\Purchase');
    }
    public function salesReturn(){
        return $this->hasMany('\App\Models\SalesReturn');
    }
    public function productsAttributes(){
        return $this->hasMany('\App\Models\ProductsAttribute');
    }
    public function discounts(){
        return $this->hasMany('\App\Models\Discount');
    }
}
