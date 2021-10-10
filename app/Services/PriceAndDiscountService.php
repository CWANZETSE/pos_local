<?php


namespace App\Services;


use App\Models\Discount;
use App\Models\ProductsAttribute;
use Carbon\Carbon;

class PriceAndDiscountService
{
    private $branch_id;
    private $size_id;
    private $current_price;
    public function __construct($branch_id,$size_id,$current_price)
    {
        $this->branch_id=$branch_id;
        $this->size_id=$size_id;
        $this->current_price=$current_price;
    }

    public function getPriceAndDiscount(){
        $discount=Discount::where('branch_id',$this->branch_id)
            ->where('size_id',$this->size_id)
            ->latest()
            ->first();
        if ($discount==null){
            $price=$this->current_price;
            return $price;
        }else{
            if ($discount->expiry_date<Carbon::today()){
                $price=$this->current_price;
                return $price;
            }else{
                $price=$discount->amount;
                return $price;
            }

        }
    }

    public function getProductDiscount(){
        $discount=Discount::where('branch_id',$this->branch_id)
            ->where('size_id',$this->size_id)
            ->latest()
            ->first();
        if ($discount==null){
            $singleProductDiscount=0;
            return $singleProductDiscount;
        }else{
            if ($discount->expiry_date<Carbon::today()){
                $singleProductDiscount=0;
                return $singleProductDiscount;
            }else{
                $singleProductDiscount=$this->current_price-$discount->amount;
                return $singleProductDiscount;
            }

        }

    }

}
