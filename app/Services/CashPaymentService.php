<?php


namespace App\Services;


use App\Models\CashPayment;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class CashPaymentService
{
    public $cashPaid;
    public $change;
    public $totalBill;

    public function __construct($cashPaid,$change,$totalBill)
    {
        $this->cashPaid=$cashPaid;
        $this->change=$change;
        $this->totalBill=$totalBill;
    }

    public function saveCashPayment(){
        CashPayment::create([
            'user_id'=>Auth::user()->id,
            'branch_id'=>Auth::user()->branch_id,
            'sale_id'=>Sale::where('user_id',Auth::user()->id)->latest()->first()->id,
            'total'=>$this->totalBill,
            'tendered'=>$this->cashPaid,
            'change'=>$this->change,
        ]);
    }
}
