<?php


namespace App\Services;


use App\Models\ProductsAttribute;
use App\Models\Profit;
use App\Models\Purchase;
use App\Models\RunningStock;
use App\Models\Sale;
use App\Models\Size;
use Illuminate\Support\Facades\Auth;

class CalculateProfitService
{
    private $items;

    public function __construct($items)
    {
        $this->items=$items;
    }

    public function gettingProfit(){
        $margin=0;
        foreach ($this->items as $key=>$item){
            $productId=ProductsAttribute::where('sku',$item['sku'])->first()->product_id;
            $branch_id=Auth::user()->branch->id;
            $sizeId=Size::where('id',$item['size_id'])->where('product_id',$productId)->first()->id;
            $user_id=Auth::user()->id;
            $attribute_id=$key;
            $purchaseData=RunningStock::where('branch_id',$branch_id)
                ->where('size_id',$sizeId)
                ->where('description','purchase')
                ->latest()
                ->first();

            $buying_price=$purchaseData->unit_cost;
            $quantity=$item['quantity'];
            $selling_price=(new PriceAndDiscountService($branch_id,$sizeId,$item['price']))->getPriceAndDiscount();
            $buy_total=$buying_price*$quantity;
            $sell_total=$selling_price*$quantity;
            $margin1=$sell_total-$buy_total;
            $margin+=$margin1;
        }
        $sale=Sale::where('branch_id',$branch_id)
            ->where('user_id',$user_id)
            ->latest()
            ->first();
        $sale->update([
            'margin'=>$margin,
        ]);
    }


}
