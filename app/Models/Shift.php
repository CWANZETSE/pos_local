<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

    protected $fillable=[
        'user_id',
        'opening_admin_id',
        'closing_admin_id',
        'shift_opened',
        'shift_closed',
        'branch_id',
        'closing_user_id',
    ];
    use HasFactory;

    public function user(){
        return $this->belongsTo('\App\Models\User');
    }
}
