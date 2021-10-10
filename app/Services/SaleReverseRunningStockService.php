<?php


namespace App\Services;


use App\Models\RunningStock;
use Illuminate\Support\Facades\Auth;

class SaleReverseRunningStockService
{
    protected $size_id;
    protected $saleProdAttrQty;
    protected $branch_id;

    public function __construct($size_id,$saleProdAttrQty,$branch_id)
    {
        $this->size_id=$size_id;
        $this->saleProdAttrQty=$saleProdAttrQty;
        $this->branch_id=$branch_id;
    }

    public function createRunningStock(){

        $balance=RunningStock::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->latest()->first()->balance+$this->saleProdAttrQty;

        $runningStock=new RunningStock();
        $runningStock->create([
            'branch_id'=>$this->branch_id,
            'admin_id'=>Auth::user()->id,
            'size_id'=>$this->size_id,
            'units'=>$this->saleProdAttrQty,
            'balance'=>$balance,
            'description'=>'Reversal',
        ]);
    }
}
