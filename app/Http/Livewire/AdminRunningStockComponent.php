<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\RunningStock;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\Size;
use App\Models\User;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use NumberToWords\NumberToWords;

class AdminRunningStockComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $reportReady;
    public $category_id;
    public $product_id;
    public $size_id;
    public $branch_id;
    public $date_from;
    public $date_to;
    public $perPage;
    public $searchCode;
    public $category;
    public $product;
    public $size;
    public $selectedPeriod="Select date from options";

    public function mount(){
        $this->reportReady=false;
        $this->perPage=10;
    }

    public function ShowDateRangeModal(){
        $this->dispatchBrowserEvent('ShowDateRangeModalEvent');
    }
    public function PredefinedPeriod($str){
        $this->reportReady= !($this->branch_id === null) && !($this->branch_id === "");
        if($str==="today"){
            $this->selectedPeriod='Today';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $time='Day';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="yesterday"){
            $this->selectedPeriod='Yesterday';
            $date_from=Carbon::yesterday();
            $date_to=Carbon::yesterday();
            $time='Day';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="this_week"){
            $this->selectedPeriod='This Week';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $time='Week';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="last_week"){
            $this->selectedPeriod='Last Week';
            $date_from=Carbon::now()->subWeek();
            $date_to=Carbon::now()->subWeek();
            $this->date_from = Carbon::parse($date_from)
                ->startOfWeek()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfWeek()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="this_month"){
            $this->selectedPeriod='This Month';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $this->date_from = Carbon::parse($date_from)
                ->startOfMonth()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfMonth()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="last_month"){
            $this->selectedPeriod='Last Month';
            $date_from=Carbon::now()->subMonth();
            $date_to=Carbon::now()->subMonth();
            $this->date_from = Carbon::parse($date_from)
                ->startOfMonth()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfMonth()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="this_year"){
            $this->selectedPeriod='This Year';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $this->date_from = Carbon::parse($date_from)
                ->startOfYear()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="last_year"){
            $this->selectedPeriod='Last Year';
            $date_from=Carbon::now()->subYear();
            $date_to=Carbon::now()->subYear();
            $this->date_from = Carbon::parse($date_from)
                ->startOfYear()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfYear()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }


    }
    public function FillDateRange($date_from,$date_to,$time): void
    {
        $start="startOf".$time;
        $end="endOf".$time;

        $this->date_from = Carbon::parse($date_from)
            ->$start()      // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $this->date_to = Carbon::parse($date_to)
            ->$end()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
    }

    public function updatedBranchId(){
        $this->category_id="";
        $this->product_id="";
        $this->size_id="";
        $this->date_from="";
        $this->date_to="";
        $this->searchCode="";
        $this->reportReady=false;
        $this->resetPage();
    }

    public function updatedDateFrom(){
        $this->reportReady=false;
        $this->date_to="";
        $this->resetPage();
    }
    public function updatedDateTo(){
        $this->reportReady=false;
        $this->resetPage();
    }

    public function downloadPDF(){
        $date_from=$this->date_from;
        $date_to=$this->date_to;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $this->reportReady=true;
        $size_id=Size::whereSku($this->searchCode)->first()?Size::whereSku($this->searchCode)->first()->id:"";
        $product_id=Size::whereSku($this->searchCode)->first()->product_id;
        $runningStocks=RunningStock::where('branch_id',$this->branch_id)
                        ->where('size_id',$size_id)
                        ->whereBetween('created_at', [$from, $to])
                        ->get();
        $branch=Branch::find($this->branch_id)->name;
        $size=Size::whereSku($this->searchCode)->first()->name;
        $sku=$this->searchCode;
        $product=Product::whereId($product_id)->first()->name;
        $openingStock=RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->whereBetween('created_at', [$from, $to])
            ->first() ? RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->whereBetween('created_at', [$from, $to])
            ->first()->balance:0;
        $closingStock=RunningStock::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->first()?
                RunningStock::where('branch_id',$this->branch_id)
                ->where('size_id',$size_id)
                ->whereBetween('created_at', [$from, $to])
                ->latest()
                ->first()->balance:0;



        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }
        (new LogsService('downloaded run stock report' ,'Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.runningStock',compact(['runningStocks','branch','from','to','product','size','logo','openingStock','closingStock','sku']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );


    }

    public function render()
    {
        $AdminBranchId=auth()->user()->branch_id;
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!=="" && $this->date_to!=="" && $this->branch_id!=="" && $this->searchCode!=="") {

            $size_id=Size::whereSku($this->searchCode)->first()?Size::whereSku($this->searchCode)->first()->id:null;

            if($size_id!==null){
                $this->reportReady=true;
                $size_name=Size::where('id', $size_id)->first()? Size::findOrFail($size_id)->name:"";
                $product_id=Size::where('id', $size_id)->first()? Size::findOrFail($size_id)->product_id:"";
                $product_name=Size::where('id', $size_id)->first()? Product::findOrFail($product_id)->name:"";
                $category_id=Size::where('id', $size_id)->first()?Product::findOrFail($product_id)->category_id:"";
                $category_name=Size::where('id', $size_id)->first()?Category::findOrFail($category_id)->name:"";

                $this->category=$category_name;
                $this->product=$product_name;
                $this->size=$size_name;
            }else{
                $this->reportReady=false;
            }
            $runningStocks=RunningStock::where('branch_id',$this->branch_id)
                                        ->where('size_id',$size_id)
                                        ->whereBetween('created_at', [$from, $to])
                                        ->paginate($this->perPage);

        }else{
            $this->reportReady=false;
            $runningStocks=[];
        }

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }

        return view('livewire.admin-running-stock-component',compact(['branches','runningStocks','AdminBranchId']))->layout('layouts.admin');
    }
}
