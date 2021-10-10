<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBank extends Model
{
    use HasFactory;

    protected $fillable=[
        'supplier_id',
        'bank_name',
        'account_number',
        'bank_additional_details',
    ];

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }
}
