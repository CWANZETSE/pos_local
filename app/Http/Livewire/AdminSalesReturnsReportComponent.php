<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Models\CardPayment;
use App\Models\Declarations;
use App\Models\Mpesa;
use App\Models\MpesaPayment;
use App\Models\Profit;
use App\Models\RunningStock;
use App\Models\User;
use App\Services\CalculateProfitService;
use App\Services\LogsService;
use App\Services\SaleReverseRunningStockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;


class AdminSalesReturnsReportComponent extends Component
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
    public $txn_code;
    public $SaleAmount;
    public $created_at;
    public $updated_at;
    public $mac_address;
    public $ip_address;
    public $items=[];
    public $CardPaymentDetails=[];
    public $MpesaPaymentDetails=[];
    public $canceled_by;
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

    public function ViewSaleModal($saleId){
        $this->sale_id=$saleId;
        $sale=Sale::find($saleId);
        $this->user=$sale->user->name;
        $this->txn_code=$sale->txn_code;
        $this->SaleAmount=$sale->total;
        $this->created_at=$sale->created_at;
        $this->updated_at=$sale->updated_at;
        $this->mac_address=$sale->mac_address;
        $this->ip_address=$sale->ip_address;
        $this->items=unserialize($sale->sale);
        $this->canceled_by=$sale->canceled_by==null?null:Admin::find($sale->canceled_by)->name;
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
            ->where('reversed',1)
            ->whereBetween('updated_at', [$from, $to])
            ->get();

        $branch=Branch::findOrFail($branch_id)->name;

        $reversed_amount=SalesReturn::where('branch_id',$this->branch_id)
            ->whereBetween('updated_at', [$from, $to])
            ->sum('total');

        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }

        (new LogsService('downloaded sales retrn report' ,'Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.sales-return',compact(['sales','branch','from','to','reversed_amount','logo']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );


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
        if ($this->date_from!="" && $this->date_to!="") {
            $orders=Sale::with('branch')
                ->with('user')
                ->where('branch_id',$this->branch_id)
                ->where('reversed',1)
                ->whereBetween('updated_at', [$from, $to])
                ->paginate($this->perPage);
            $count=Sale::with('branch')
                ->with('user')
                ->where('branch_id',$this->branch_id)
                ->where('reversed',1)
                ->whereBetween('updated_at', [$from, $to])
                ->get()
                ->count();
        }else{
            $orders=[];
            $count=0;
        }
        if (Auth::user()->role_id===Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }


        return view('livewire.admin-sales-returns-report-component',['branches'=>$branches,'sales'=>$orders,'count'=>$count,'AdminBranchId'=>$AdminBranchId])->layout('layouts.admin');
    }
}
