<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable=[
        'till_status',
        'name',
        'location',
        'unbanked_balance'
    ];

    public function products(){
    	return $this->hasMany('\App\Models\Product');
    }

    public function purchases(){
    	return $this->hasMany('\App\Models\Purchase');
    }

    public function users(){
        return $this->hasMany('\App\Models\User');
    }

    public function sales(){
        return $this->hasMany('\App\Models\Sale');
    }
    public function declarations(){
        return $this->hasMany('\App\Models\Declaration');
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
