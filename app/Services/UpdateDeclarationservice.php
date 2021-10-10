<?php


namespace App\Services;


use App\Models\Declarations;
use Illuminate\Support\Carbon;

class UpdateDeclarationservice
{
    public $user_id;
    public $branch_id;
    public $admin_id;
    public $amount;


    public function __construct($user_id, $branch_id, $admin_id,$amount)
    {
        $this->user_id = $user_id;
        $this->branch_id = $branch_id;
        $this->admin_id = $admin_id;
        $this->amount = $amount;
    }

    public function updateDeclaration(){
        Declarations::create([
            'user_id'=>$this->user_id,
            'branch_id'=>$this->branch_id,
            'txn_date'=>Carbon::now(),
            'amount'=>-$this->amount,//Note the -ve sign
            'reference'=>random_int(100000000000000,999999999999999),
            'admin_id'=>$this->admin_id,
            'destination'=>'admin',
            'status'=>1,
            'details'=>'self',
            'comments'=>'Sale Reversal',
            'float'=>0,
        ]);
    }
}
