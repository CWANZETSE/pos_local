<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningStock extends Model
{
    use HasFactory;
    protected $fillable=[
        'branch_id',
        'unit_cost',
        'user_id',
        'admin_id',
        'size_id',
        'units',
        'balance',
        'description',
        ];
}
