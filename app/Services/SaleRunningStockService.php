<?php


namespace App\Services;


use App\Models\RunningStock;
use Illuminate\Support\Facades\Auth;

class SaleRunningStockService
{
    protected $size_id;
    protected $units;
    protected $originalAttrQty;

    public function __construct($size_id,$units,$originalAttrQty)
    {
        $this->size_id=$size_id;
        $this->units=$units;
        $this->originalAttrQty=$originalAttrQty;
    }

    public function createRunningStock(){
        $balance=RunningStock::where('size_id',$this->size_id)->latest()->first()?RunningStock::where('size_id',$this->size_id)->latest()->first()->balance-$this->units:$this->originalAttrQty;
        $runningStock=new RunningStock();
        $runningStock->create([
            'branch_id'=>Auth::user()->branch_id,
            'user_id'=>Auth::user()->id,
            'size_id'=>$this->size_id,
            'units'=>$this->units,
            'balance'=>$balance,
            'description'=>'sale',
        ]);
    }
}
