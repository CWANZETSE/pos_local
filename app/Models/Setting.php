<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable=[
    	'phone',
    	'email',
    	'physical_address',
    	'postal_address',
    	'logo',

    ];
}
