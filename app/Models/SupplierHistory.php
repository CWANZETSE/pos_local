<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierHistory extends Model
{
    use HasFactory;

    protected $fillable=[
      'supplier_code',
      'invoice_id',
      'description',
      'money_in',
      'money_out',
      'balance',
    ];
}
