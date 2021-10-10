<?php


namespace App\Services;


use App\Models\RunningStock;
use Illuminate\Support\Facades\Auth;

class PurchaseRunningStockService
{
    protected $size_id;
    protected $units;
    protected $branch_id;
    protected $unit_cost;

    public function __construct($size_id,$units,$branch_id,$unit_cost)
    {
        $this->size_id=$size_id;
        $this->units=$units;
        $this->branch_id=$branch_id;
        $this->unit_cost=$unit_cost;
    }

    public function createRunningStock(){
        $StockCount=RunningStock::all()->count();
        if($StockCount==0){
            $balance=$this->units;
        }else{
            $branchData=RunningStock::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->first();
            if($branchData==null){
                $balance=$this->units;
            }else{
                $balance=RunningStock::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->latest()->first()->balance+$this->units;
            }

        }
        $runningStock=new RunningStock();
        $runningStock->create([
            'branch_id'=>$this->branch_id,
            'admin_id'=>Auth::user()->id,
            'size_id'=>$this->size_id,
            'units'=>$this->units,
            'unit_cost'=>$this->unit_cost,
            'balance'=>$balance,
            'description'=>'purchase',
        ]);
    }
}
