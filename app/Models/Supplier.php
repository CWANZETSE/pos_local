<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable=[
    	'name',
    	'email',
    	'bank_name',
    	'contact',
    	'address',
    	'status',
        'bank_account_number',
        'bank_additional_details',
        'supplier_code',
        'invoice_due_days',
    ];

    public function purchases(){
    	return $this->hasMany('App\Models\Purchase');
    }
    public function supplierBanks(){
        return $this->hasMany('App\Models\SupplierBank');
    }
}
