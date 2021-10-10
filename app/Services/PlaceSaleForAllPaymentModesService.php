<?php


namespace App\Services;


use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use App\Models\Sale;
use App\Models\Size;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaceSaleForAllPaymentModesService
{
    private $items;
    private $totalBill;

    public function __construct($items,$totalBill)
    {
        $this->items=$items;
        $this->totalBill=$totalBill;
    }

    public function placingSale(){

        $txn_code=mt_rand(1000000000,9999999999);




        // REDUCE QUANTITY FOR SKU AND CALCULATE DISCOUNT

        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
        }else{
            $setting=$allSettings->first();
        }

        $setTaxPercentage=$setting ? $setting->tax_percentage : 0;

        $tax=0;
        $total_discount=0;

        foreach ($this->items as $key => $item) {
            $total_discount+=$item['discount']*$item['quantity'];
            $ifTaxable=Size::find($item['size_id'])->taxable;

            if($ifTaxable==1) {
                $tax+=($setTaxPercentage/100)*($item['price']*$item['quantity']);
            }
            $quantity=$item['quantity'];

            ProductsAttribute::find($key)->decrement('stock',$quantity);

            if (ProductsAttribute::find($key)->stock<0) {
                ProductsAttribute::find($key)->update(['stock'=>0]);
            }

        }

        $sale=new Sale;
        $sale->txn_code= $txn_code;
        $sale->mac_address= request()->ip();
        $sale->ip_address= request()->ip();
        $sale->user_id=Auth::user()->id;
        $sale->branch_id=Auth::user()->branch_id;
        $sale->total=$this->totalBill;
        $sale->total_discount=$total_discount;
        $sale->tax=$tax;
        $sale->tax_rate=$setting ? $setting->tax_percentage : 0;
        $sale->sale=serialize(session()->get('pos'));
        $sale->save();
    }

}
