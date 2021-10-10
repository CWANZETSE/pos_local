<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Purchase;
use App\Models\RunningStock;
use App\Models\Size;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AdminPriceComponent extends Component
{
    public $state=[];
    public $date_to;
    public $products;
    public $sizes;
    public $current_price;
    public $buying_price;
    public $discountActive;
    public $discount_amount;
    public $latestDiscount=[];
    public $reportDiscount=[];
    public $report_branch_id;
    public $report_status;
    public $report_date_from;
    public $report_date_to;
    public $pdfReportReady=false;
    public $productExists=false;

    public $category_id;
    public $product_id;
    public $size_id;

    public $category;
    public $product;
    public $size;
    public $sku_code;
    public $branch_id;
    public $new_price;

    protected $rules=[
            'new_price'=>'required',
            'branch_id'=>'required',
            'category'=>'required',
            'product'=>'required',
            'size'=>'required',
        ];

    public function mount(){
        $this->products=[];
        $this->sizes=[];
        $this->state=[];
        $this->current_price=0.00;
        $this->buying_price=0.00;
        $this->state['amount']=0.00;
        $this->discountActive=false;
        $this->date_to=null;
        $this->category="";
        $this->product="";
        $this->size="";
        $this->sku_code="";
        $this->branch_id="";
    }
    public function updatedBranchId(){

        $this->clearInputs();

    }

    public function clearInputs(){
        $this->productExists=false;
        $this->current_price=0.00;
        $this->buying_price=0.00;
        $this->date_to="";
        $this->category_id="";
        $this->product_id="";
        $this->size_id="";
        $this->category="";
        $this->product="";
        $this->size="";
        $this->new_price="";
    }


    public function updatedSkuCode(){


        $size= Size::where('sku', $this->sku_code)->first() ?: null;
        $size_id=Size::where('sku',$this->sku_code)->first()?Size::where('sku',$this->sku_code)->first()->id:null;

        $size_name=Size::where('sku', $this->sku_code)->first()? Size::findOrFail($size_id)->name:"";
        $product_id=Size::where('sku', $this->sku_code)->first()? Size::findOrFail($size_id)->product_id:"";
        $product_name=Size::where('sku', $this->sku_code)->first()? Product::findOrFail($product_id)->name:"";
        $category_id=Size::where('sku', $this->sku_code)->first()?Product::findOrFail($product_id)->category_id:"";
        $category_name=Size::where('sku', $this->sku_code)->first()?Category::findOrFail($category_id)->name:"";

        $this->category_id=$category_id;
        $this->product_id=$product_id;
        $this->size_id=$size_id;


        $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->latest()
            ->first();
        if($attrib!==null){
            $this->category=$category_name;
            $this->product=$product_name;
            $this->size=$size_name;
        }else{
            $this->clearInputs();
        }

        $attribPrice=$attrib?$attrib->price:0;
        $size_id=Size::where('sku',$this->sku_code)->first()?Size::where('sku',$this->sku_code)->first()->id:null;
        $buyingData=RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->where('description','purchase')
            ->latest()
            ->first();

        $this->productExists=$buyingData?true:false;
        $buyingCost=$buyingData?$buyingData->unit_cost:0;
        $this->current_price=number_format($attribPrice,2);
        $this->buying_price=number_format($buyingCost,2);

    }

    public function updatePrice(){
        $this->validate();
        $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
            ->where('size_id',$this->size_id)
            ->latest()
            ->first();

        $size_id=Size::where('sku',$this->sku_code)->first()?Size::where('sku',$this->sku_code)->first()->id:null;
        $buyingData=RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->where('description','purchase')
            ->latest()
            ->first();

        if ($buyingData->unit_cost<$this->new_price){
            $attrib->update([
                'price'=>$this->new_price,
            ]);
            $buyingData->update([
                'rrp'=> $this->new_price,
            ]);
            $this->clearInputs();
            $this->branch_id="";
            $this->sku_code="";
            (new LogsService('updated price '.$this->sku_code ,'Admin'))->storeLogs();
            $this->dispatchBrowserEvent('showSuccessEvent',['message'=>'Price Updated Successfully!','type'=>'success']);
        }else{
            (new LogsService('attempted price update '.$this->sku_code ,'Admin'))->storeLogs();
            $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Higher cost price. Price must be above cost price','type'=>'error']);
        }



    }
    public function render()
    {
        $branches=Branch::all();
        $categories=Category::all();
        return view('livewire.admin-price-component',compact(['branches','categories']))->layout('layouts.admin');
    }
}
