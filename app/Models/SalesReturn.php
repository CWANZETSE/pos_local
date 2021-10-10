<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    public function branch(){
    	return $this->belongsTo('App\Models\Branch');
    }

    public function sale(){
    	return $this->belongsTo('App\Models\Sale');
    }

    public function admin(){
    	return $this->belongsTo('App\Models\Admin'); 
    }
    public function product(){
        return $this->belongsTo('App\Models\Product'); 
    }
}
