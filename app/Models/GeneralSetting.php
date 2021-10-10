<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    CONST CASH_ENABLED=10;
    CONST CASH_DISABLED=11;
    CONST MPESA_ENABLED=13;
    CONST MPESA_DISABLED=14;
    CONST KCB_PINPAD_ENABLED=15;
    CONST KCB_PINPAD_DISABLED=16;


	protected $fillable=[
	    'logo',
	'store_footer_copyright',
	'store_name',
	'store_address',
	'store_phone',
	'store_email',
	'store_website',
	'tax_percentage',
    'printer_name',
        'cash',
        'mpesa',
        'kcb_pinpad',
	];
    use HasFactory;
}
