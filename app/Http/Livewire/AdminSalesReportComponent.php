<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Exports\ExcelSales;
use App\Models\Admin;
use App\Models\CardPayment;
use App\Models\CashPayment;
use App\Models\Declarations;
use App\Models\Mpesa;
use App\Models\MpesaPayment;
use App\Models\Profit;
use App\Models\RunningStock;
use App\Models\User;
use App\Services\CalculateProfitService;
use App\Services\LogsService;
use App\Services\SaleReverseRunningStockService;
use App\Services\UpdateDeclarationservice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;


class AdminSalesReportComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $branch_id;
	public $date_from;
	public $date_to;
	public $perPage;
	public $reportReady;
	public $printMode;
	public $saleIdForReversal;
	public $sale_id;

	public $user;
	public $canceled_by;
	public $reversed_on;
	public $txn_code;
	public $SaleAmount;
	public $created_at;
	public $mac_address;
	public $ip_address;
	public $items=[];
	public $CardPaymentDetails=[];
	public $MpesaPaymentDetails=[];

    public $search_type;
    public $viewFilters;
    public $searchCode;
    public $selectedPeriod="Select date from options";


	public function mount(){
		$this->reportReady=false;
        $this->viewFilters=true;
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

    public function AllowReprint($sale_id): void
    {

	    $sale=Sale::find($sale_id);
	    if($sale->reversed===1){
            $this->dispatchBrowserEvent('ReprintNotAllowedForReversedSaleModalEvent');
        }else{
            $sale->update([
                'allow_reprint'=>1,
            ]);
        }

    }
    public function CancelReprint($sale_id): void
    {
        $sale=Sale::find($sale_id);
        $sale->update([
            'allow_reprint'=>0,
        ]);
        (new LogsService('canceled reprint '.$sale->txn_code ,'Admin'))->storeLogs();
    }
    public function updatedSearchType(){
        $searchType=$this->search_type;
        $this->searchCode="";
        if($searchType==="filter"){
            $this->viewFilters=true;
        }else{
            $this->viewFilters=false;
        }
    }

	public function updatedBranchId(){
		$this->date_from="";
		$this->date_to="";
        $this->reportReady=false;
        $this->resetPage();
	}
	public function updatedDateFrom(){
        $this->selectedPeriod='Custom Date';
        $this->reportReady=false;
		$this->date_to="";
        $this->resetPage();
	}
	public function updatedDateTo(){
        $this->selectedPeriod='Custom Date';
		$this->reportReady=$this->CheckReportReadyStatus();
        $this->resetPage();
	}

    private function CheckReportReadyStatus()
    {
        if ($this->date_from!=="" && $this->date_to!=="" && $this->branch_id!=="") {
            return true;
        }else{
            return false;
        }
    }

	public function ViewSaleModal($saleId){
	    $this->sale_id=$saleId;
        $sale=Sale::find($saleId);

        $this->user=$sale->user->name;
        $this->txn_code=$sale->txn_code;
        $this->SaleAmount=$sale->total;
        $this->created_at=$sale->created_at;
        $this->mac_address=$sale->mac_address;
        $this->ip_address=$sale->ip_address;
        $this->canceled_by=$sale->canceled_by;
        $this->reversed_on=$sale->reversed_on;
        $this->items=unserialize($sale->sale);
        $this->dispatchBrowserEvent('showSaleModalEvent');
        $this->CardPaymentDetails=CardPayment::where('sale_id',$this->sale_id)?CardPayment::where('sale_id',$this->sale_id)->first():[];
        $this->MpesaPaymentDetails=Mpesa::where('BillRefNumber',$this->sale_id)?Mpesa::where('BillRefNumber',$this->sale_id)->first():[];
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
	        $sales=Sale::with('branch')
	                    ->with('user')
	                     ->where('branch_id',$this->branch_id)
	                     ->where('reversed',0)
	                     ->whereBetween('created_at', [$from, $to])
	                     ->get();

	        $branch=Branch::findOrFail($branch_id)->name;

	        $reversed_amount=SalesReturn::where('branch_id',$this->branch_id)
	                        ->whereBetween('created_at', [$from, $to])
	                        ->sum('total');

	        $settingsCount=GeneralSetting::all()->count();
	        if ($settingsCount==0) {
		        $logo='null';
	    	}else{
	    		$logo=GeneralSetting::first()->logo;
	    	}

            (new LogsService('downloaded sales report' ,'Admin'))->storeLogs();
			$pdfContent = PDF::loadView('pdf.sales',compact(['sales','branch','from','to','reversed_amount','logo']))->output();
				 return response()->streamDownload(
			     fn () => print($pdfContent),
			     "filename.pdf"
			);


	}

	public function downloadExcel(){
        $branch_id=$this->branch_id;
        $date_from=$this->date_from;
        $date_to=$this->date_to;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $sales=Sale::with('branch')
            ->with('user')
            ->where('branch_id',$this->branch_id)
            ->where('reversed',0)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        return Excel::download(new ExcelSales($sales), 'sales.xlsx');
    }

	public function confirmReverseSale($saleId){
	        $sale=Sale::find($saleId);

	        if(Auth::user()->role_id===Admin::IS_ADMINISTRATOR){
                $this->saleIdForReversal=$saleId;
                $this->dispatchBrowserEvent('showSaleReversalModal');
            }else{
                if(Carbon::parse($sale->created_at)->toDateString()===Carbon::today()->toDateString()){
                    $this->saleIdForReversal=$saleId;
                    $this->dispatchBrowserEvent('showSaleReversalModal');
                }else{
                    $this->dispatchBrowserEvent('showSaleReversalErrorModal',['message'=>'Insufficient privileges to reverse sale']);
                    return false;
                }
            }

    }

    public function reverseConfirmedSale(){

    	$sale=Sale::findOrFail($this->saleIdForReversal);
    	$sale->update([
    		'reversed'=>1,
    		'canceled_by'=>auth()->user()->id,
            'reversed_on'=>Carbon::now(),
    	]);

        try {
            $cashpayment=CashPayment::where('sale_id',$this->saleIdForReversal)->first();
            $cardpayment=CardPayment::where('sale_id',$this->saleIdForReversal)->first();
            if($cashpayment!==null){
                $cashpayment->update([
                    'reversed'=>CashPayment::IS_REVERSED,
                ]);
                $user_id=$sale->user_id;
                $branch_id=$sale->branch_id;
                $admin_id=Auth::user()->id;
                $amount=$sale->total;
                (new UpdateDeclarationservice($user_id,$branch_id,$admin_id,$amount))->updateDeclaration();
            }
            if($cardpayment!==null){
                $cardpayment->update([
                    'reversed'=>CardPayment::IS_REVERSED,
                ]);
            }

        } catch (ErrorException $e) {
            // Do stuff if it doesn't exist.
        }

        $sale_products=unserialize($sale->sale);

        foreach ($sale_products as $key => $saleProdAttr) {

        	$attr=ProductsAttribute::findOrFail($key);
            $attr->update([
                'stock'=>$attr->stock+$saleProdAttr['quantity'],
            ]);

            (new SaleReverseRunningStockService($saleProdAttr['size_id'],$saleProdAttr['quantity'],$attr->branch_id))->createRunningStock();
        }

    	$this->dispatchBrowserEvent('hideSaleReversalModal',['message'=>'Sale Reversed Successfully!']);

    }


    public function render()
    {
    	$from    = Carbon::parse($this->date_from)
                 ->startOfDay()        // 2018-09-29 00:00:00.000000
                 ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
                 ->endOfDay()          // 2018-09-29 23:59:59.000000
                 ->toDateTimeString(); // 2018-09-29 23:59:59
        $AdminBranchId=auth()->user()->branch_id;

        if($this->search_type=="code") {
            $orders = Sale::with('branch')
                ->with('user')
                ->where('txn_code',$this->searchCode)
                ->paginate($this->perPage);
        }else{

            if ($this->date_from !== "" && $this->date_to !=="") {
                $orders = Sale::with('branch')
                    ->with('user')
                    ->where('branch_id', $this->branch_id)
                    ->whereBetween('created_at', [$from, $to])
                    ->paginate($this->perPage);

            } else {
                $orders = [];
            }
        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }


        return view('livewire.admin-sales-report-component',['branches'=>$branches,'sales'=>$orders,'AdminBranchId'=>$AdminBranchId])->layout('layouts.admin');
    }
}
