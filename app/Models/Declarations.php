<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declarations extends Model
{
    use HasFactory;
    const IS_PENDING=0;
    const IS_APPROVED=1;
    const IS_REJECTED=2;

    protected $fillable=[
      'user_id',
      'branch_id',
      'txn_date',
      'amount',
      'reference',
      'admin_id',
      'destination',
      'status',
      'details',
        'comments',
        'float',
    ];

    public function user(){
        return $this->belongsTo('\App\Models\User');
    }
    public function branch(){
        return $this->belongsTo('\App\Models\Branch');
    }
    public function admin(){
        return $this->belongsTo('\App\Models\Admin');
    }
}
