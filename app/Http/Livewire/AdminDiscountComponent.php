<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Discount;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Purchase;
use App\Models\RunningStock;
use App\Models\Size;
use App\Models\User;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use PDF;

class AdminDiscountComponent extends Component
{
    public $state=[];

    public $date_to;
    public $category;
    public $category_id;
    public $product_id;
    public $product;
    public $size_id;
    public $size;
    public $current_price;
    public $buying_price;
    public $discountActive;
    public $discount_amount;
    public $discount_expiry;
    public $latestDiscount=[];
    public $reportDiscount=[];
    public $report_branch_id;
    public $report_status;
    public $report_date_from;
    public $report_date_to;
    public $pdfReportReady=false;
    public $sku_code;
    public $branch_id;
    public $amount;
    public $attributeInBranch=false;

    protected $rules = [
        'branch_id' => 'required',
        'amount' => 'required',
    ];

    public function mount(){

        $this->category_id="";
        $this->product_id="";
        $this->size_id="";

        $this->category="";
        $this->product="";
        $this->size="";
        $this->state=[];
        $this->current_price=0.00;
        $this->buying_price=0.00;
        $this->state['amount']=0.00;
        $this->discountActive=false;
        $this->attributeInBranch=false;
        $this->date_to=null;
        $this->sku_code="";
        $this->amount="";
    }

    public function updatedBranchId(){
        $this->category_id="";
        $this->product_id="";
        $this->size_id="";

        $this->category="";
        $this->product="";
        $this->size="";
        $this->sku_code="";
        $this->amount="";
        $this->current_price=0.00;
        $this->buying_price=0.00;
        $this->state['amount']=0.00;
        $this->date_to="";
        $this->discountActive=false;
        $this->attributeInBranch=false;
        $this->latestDiscount=[];
    }

    public function clearInputs(){
        $this->current_price=0.00;
        $this->buying_price=0.00;
        $this->state['amount']=0.00;
        $this->discountActive=false;
        $this->attributeInBranch=false;
        $this->latestDiscount=[];
        $this->category="";
        $this->product="";
        $this->size="";
        $this->amount="";
    }
    public function updatedSkuCode(){
        $this->clearInputs();
        $size= Size::where('sku', $this->sku_code)->first() ?: null;
        $size_id=Size::where('sku',$this->sku_code)->first()?Size::where('sku',$this->sku_code)->first()->id:null;
        $this->size_id=$size_id;

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
        $buyingData=RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->where('description','purchase')
            ->latest()
            ->first();
        if($attrib!=null){
            $discount=Discount::where('branch_id',$this->branch_id)
                ->where('size_id',$size_id)
                ->latest()
                ->first();
            $this->attributeInBranch=true;
            $this->category=$category_name;
            $this->product=$product_name;
            $this->size=$size_name;
            if ($discount!=null){
                $expiry=$discount->expiry_date;
                if ($expiry>=Carbon::today()){
                    $this->discount_amount=$discount->amount;
                    $this->date_to=$discount->expiry_date;
                    $this->amount=$discount->amount;
                    $this->discountActive=true;
                }
            }

            $this->current_price=number_format($attrib->price,2);
            $this->buying_price=number_format($buyingData->unit_cost,2);
        }else{
            $this->current_price=0.00;
            $this->buying_price=0.00;
            $this->amount=0.00;
            $this->discountActive=false;
            $this->attributeInBranch=false;
        }

    }


    public function createDiscount(){

        $this->validate();

        $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
            ->where('size_id',$this->size_id)
            ->latest()
            ->first();

        if($attrib==null){
            $this->dispatchBrowserEvent('errorCreatingDiscountEvent',['message'=>'No Product in Branch to Discount!','type'=>'error']);
        }else if($this->date_to==""){
            $this->dispatchBrowserEvent('errorCreatingDiscountEvent',['message'=>'Expiry Date is Required!','type'=>'error']);
        }else{
            $this->submitData();
        }

    }

    public function submitData(){
        $formatedExpiryDate= Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if($formatedExpiryDate<Carbon::today()){
            $this->dispatchBrowserEvent('errorCreatingDiscountEvent',['message'=>'Invalid Expiry Date!','type'=>'error']);
        }else{
            $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
                ->where('size_id',$this->size_id)
                ->latest()
                ->first();
            $discount=Discount::where('branch_id',$this->branch_id)
                ->where('size_id',$this->size_id)
                ->whereDate('expiry_date','>=',Carbon::today())
                ->latest()
                ->first();
            $product=RunningStock::where('branch_id',$this->branch_id)
                ->where('size_id',$this->size_id)
                ->where('description','purchase')
                ->latest()
                ->first();
            $productBuyingPrice=$product->unit_cost;
            if($productBuyingPrice>$this->amount||$this->amount>$attrib->price){
                $this->dispatchBrowserEvent('alreadyExistingDiscountEvent',['message'=>'Error on discount price. Please review amount','type'=>'error']);
            }else{
                if($discount===null){
                    $CreatedDiscount=Discount::create([
                        'branch_id'=>$this->branch_id,
                        'category_id'=>$this->category_id,
                        'product_id'=>$this->product_id,
                        'size_id'=>$this->size_id,
                        'amount'=>$this->amount,
                        'expiry_date'=>$formatedExpiryDate,
                        'admin_id'=>Auth::user()->id,
                    ]);
                    $this->latestDiscount=$CreatedDiscount;
                    $this->date_to="";
                    $this->buying_price=0.00;
                    $this->current_price=0.00;
                    $this->clearInputs();
                    $this->branch_id="";
                    $this->dispatchBrowserEvent('hideDiscountModal');
                    (new LogsService('created discount on'.$this->sku_code ,'Admin'))->storeLogs();
                    $this->sku_code="";
                    $this->dispatchBrowserEvent('successCreatingDiscountEvent',['message'=>'Discount created successfully!','type'=>'success']);
                }else{
                    (new LogsService('attempted discount on'.$this->sku_code,'Admin'))->storeLogs();
                    $this->dispatchBrowserEvent('alreadyExistingDiscountEvent',['message'=>'Active discount already exists','type'=>'error']);
                }
            }


        }
    }

    public function cancelDiscount($discountId){

        $discount=Discount::find($discountId);
        $discount->update([
           'expiry_date'=>Carbon::yesterday(),
        ]);
        $this->reportDiscount=[];
        $this->hideDiscountModal();
        $this->report_branch_id="";
        $this->report_date_from="";
        $this->report_date_to="";
        $this->report_status="";
        $this->clearInputs();
        $this->branch_id="";
        $this->sku_code="";
        $this->discount_expiry="";
        $this->dispatchBrowserEvent('successCancellingDiscountEvent',['message'=>'Success Cancelling Discount','type'=>'success']);
        $this->discountActive=false;
    }

    public function showDiscountModal(){
        $this->reportDiscount=[];
        $this->report_branch_id="";
        $this->report_date_from="";
        $this->report_date_to="";
        $this->report_status="";
        $this->pdfReportReady=false;
        $this->dispatchBrowserEvent('showDiscountModal');
    }
    public function hideDiscountModal(){
        $this->dispatchBrowserEvent('hideDiscountModal');
        $this->pdfReportReady=false;
    }

    public function updatedReportBranchId(){
        $this->reportDiscount=[];
        $this->report_status="";
        $this->report_date_from="";
        $this->report_date_to="";
        $this->pdfReportReady=false;
    }

    public function updatedReportStatus(){
        $this->reportDiscount=[];
        $this->report_date_from="";
        $this->report_date_to="";
        $this->pdfReportReady=false;
    }

    public function showDiscountReport(){
        $report_branch_id=$this->report_branch_id;
        $date_from=$this->report_date_from;
        $date_to=$this->report_date_to;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

            $query=Discount::where('branch_id',$report_branch_id);
            if($this->report_status=='active'){
                $this->reportDiscount=$query->whereDate('expiry_date','>=', Carbon::now())
                    ->get();
                $this->pdfReportReady=true;
            }else{
                if($this->report_date_from=="" || $this->report_date_to==""){
                    $this->reportDiscount=[];
                    $this->pdfReportReady=false;
                    $this->dispatchBrowserEvent('errorCreatingDiscountEvent',['message'=>'Check and Correct Dates!','type'=>'error']);
                }else{
                    $this->reportDiscount=[];
                    $this->reportDiscount=$query->whereBetween('expiry_date',[$from,$to])
                        ->get();
                    $this->pdfReportReady=true;
                }

            }


    }

    public function downloadPDF(){
        $report_branch_id=$this->report_branch_id;
        $date_from=$this->report_date_from;
        $date_to=$this->report_date_to;
        $status=$this->report_status;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $query=Discount::where('branch_id',$report_branch_id);
        if($this->report_status=='active'){
            $this->reportDiscount=$query->whereDate('expiry_date','>=', Carbon::now())
                ->get();
        }else{
            $this->reportDiscount=$query->whereBetween('expiry_date',[$from,$to])
                    ->get();
        }
        $reportDiscount=$this->reportDiscount;

        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }
        $branch=Branch::find($this->report_branch_id)->name;

        $pdfContent = PDF::loadView('pdf.discountReport',compact(['branch','reportDiscount','from','to','status','logo']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );


    }



    public function render()
    {
        $branches=Branch::all();
//        $this->reportDiscount=$this->showDiscountReport();
        $query=Discount::whereDate('expiry_date','>=', date('Y-m-d'));
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $discounts=$query->where('branch_id',auth()->user()->branch_id)->get();
        }else{
            $discounts=$query->get();
        }
        $categories=Category::all();
        return view('livewire.admin-discount-component',compact(['branches','categories','discounts']))->layout('layouts.admin');
    }

}
