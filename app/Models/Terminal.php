<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
	protected $fillable=[
		'ip_address',
		'mac_address',
		'location',
		'status',
	];
    use HasFactory;
}
