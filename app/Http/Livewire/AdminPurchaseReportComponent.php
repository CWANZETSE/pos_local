<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use PDF;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use DB;


class AdminPurchaseReportComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $branch_id;
	public $date_from;
	public $date_to;
	public $perPage=10;
	public $reportReady;
	public $printMode;
	public $purchaseId;
    public $selectedPeriod="Select date from options";


	public function mount(){
		$this->reportReady=false;
	}

    public function ShowDateRangeModal(){
        $this->dispatchBrowserEvent('ShowDateRangeModalEvent');
    }
    public function PredefinedPeriod($str){
        $this->reportReady= !($this->branch_id === null) && !($this->branch_id === "");
        $this->resetPage();
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
		$this->date_from="";
		$this->date_to="";
        $this->reportReady=false;
        $this->resetPage();
	}
	public function updatedDateFrom(){
        $this->reportReady=false;
		$this->date_to="";
        $this->resetPage();
	}
    public function updatedDateTo(){
        $this->reportReady=$this->CheckReportReadyStatus();
        $this->resetPage();
    }

    private function CheckReportReadyStatus()
    {
        if ($this->date_from!==null && $this->date_to!==null && $this->branch_id!==null) {
            return true;
        }else{
            return false;
        }
    }

	public function downloadPDF(){

			$branch_id=$this->branch_id;
	        $date_from=$this->date_from;
	        $date_to=$this->date_to;

	        $from    = Carbon::parse($date_from)
	                 ->startOfDay()        // 2018-09-29 00:00:00.000000
	                 ->toDateTimeString(); // 2018-09-29 00:00:00
	        $to      = Carbon::parse($date_to)
	                 ->endOfDay()          // 2018-09-29 23:59:59.000000
	                 ->toDateTimeString(); // 2018-09-29 23:59:59
	        $purchases=Purchase::with('branch')
                        ->with('supplier')
                        ->where('branch_id',$this->branch_id)
                        ->where('canceled',0)
                        ->whereBetween('created_at', [$from, $to])
                        ->get();
	        $branch=Branch::findOrFail($branch_id)->name;


	        $settingsCount=GeneralSetting::all()->count();
	        if ($settingsCount==0) {
		        $logo='null';
	    	}else{
	    		$logo=GeneralSetting::first()->logo;
	    	}
        (new LogsService('downloaded purchase report' ,'Admin'))->storeLogs();
			$pdfContent = PDF::loadView('pdf.purchases',compact(['purchases','branch','from','to','logo']))->output();
				 return response()->streamDownload(
			     fn () => print($pdfContent),
			     "filename.pdf"
			);


	}

	public function confirmCancelPurchase($pId){
		$this->purchaseId=$pId;
		$this->dispatchBrowserEvent('showPurchaseCancelModal');
	}

	public function cancelConfirmedPurchase(){
		$purchase=Purchase::findOrFail($this->purchaseId);

        $attribute=ProductsAttribute::where('branch_id',$purchase->branch_id)->where('sku',$purchase->size->sku)->first();
        $new_stock=$attribute->stock-$purchase->stock;

        if ($new_stock<0) {
            $this->dispatchBrowserEvent('failedCancelPurchaseEvent',['message'=>'Branch Stock is less for cancelation!']);
        } else{
            $purchase->update(['canceled'=>1,'canceled_by'=>Auth::user()->id]);

            $attribute->update(['stock'=>$new_stock]);
            (new LogsService('canceled purchases' ,'Admin'))->storeLogs();
            $this->dispatchBrowserEvent('hidePurchaseCancelModal',['message'=>'Purchase Canceled Succesfully!']);
        }

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
        if ($this->date_from!=="" && $this->date_to!=="") {
        	$purchases=Purchase::with('branch')
                        ->with('supplier')
                        ->where('branch_id',$this->branch_id)
                        ->where('canceled',0)
                        ->whereBetween('created_at', [$from, $to])
                        ->get();
	    	$count=Purchase::with('branch')
                ->with('supplier')
                ->where('branch_id',$this->branch_id)
                ->where('canceled',0)
                ->whereBetween('created_at', [$from, $to])
                 ->count();
        }else{
        	$purchases=[];
	    	$count=0;
        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }


        return view('livewire.admin-purchase-report-component',['branches'=>$branches,'purchases'=>$purchases,'count'=>$count,'AdminBranchId'=>$AdminBranchId])->layout('layouts.admin');
    }
}
