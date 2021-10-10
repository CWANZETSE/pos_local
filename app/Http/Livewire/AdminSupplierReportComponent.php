<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Models\CardPayment;
use App\Models\Declarations;
use App\Models\Mpesa;
use App\Models\MpesaPayment;
use App\Models\Profit;
use App\Models\Purchase;
use App\Models\RunningStock;
use App\Models\Supplier;
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


class AdminSupplierReportComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $supplier_id;
    public $date_from;
    public $date_to;
    public $perPage;
    public $reportReady;
    public $selectedPeriod="Select date from options";




    public function mount(){
        $this->reportReady=false;
        $this->perPage=10;
    }
    public function ShowDateRangeModal(){
        $this->dispatchBrowserEvent('ShowDateRangeModalEvent');
    }
    public function PredefinedPeriod($str){
        $this->reportReady= !($this->supplier_id === null) && !($this->supplier_id === "");
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

    public function updatedSupplierId(){
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
        if ($this->date_from!==null && $this->date_to!==null && $this->supplier_id!==null) {
            return true;
        }else{
            return false;
        }
    }


    public function downloadPDF(){
        $supplier_id=$this->supplier_id;
        $date_from=$this->date_from;
        $date_to=$this->date_to;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->supplier_id!="" && $this->date_from!="" && $this->date_to!="") {
            $purchases = Purchase::where('supplier_id', $this->supplier_id)
                ->whereBetween('created_at', [$from, $to])
                ->get();
            $pending_purchases=Purchase::where('supplier_id',$this->supplier_id)
                    ->where('payment_status',0)
                    ->whereBetween('created_at', [$from, $to])
                    ->orderBy('id','ASC')
                    ->get();
            $paid_purchases=Purchase::where('supplier_id',$this->supplier_id)
                ->where('payment_status',1)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id','ASC')
                ->get();
            $canceled_purchases=Purchase::where('supplier_id',$this->supplier_id)
                ->where('canceled',1)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id','ASC')
                ->get()->count();

            $supplier = Supplier::findOrFail($this->supplier_id)->name;
            $supplier_code = Supplier::findOrFail($this->supplier_id)->supplier_code;


            $settingsCount = GeneralSetting::all()->count();
            if ($settingsCount == 0) {
                $logo = 'null';
            } else {
                $logo = GeneralSetting::first()->logo;
            }

            (new LogsService('downloaded supplier report','Admin'))->storeLogs();
            $pdfContent = PDF::loadView('pdf.supplier', compact(['purchases','supplier', 'from', 'to','logo','supplier_code','pending_purchases','paid_purchases','canceled_purchases']))->output();
            return response()->streamDownload(
                fn() => print($pdfContent),
                "filename.pdf"
            );
        }else{
            return false;
        }


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
        if ($this->supplier_id!="" && $this->date_from!="" && $this->date_to!="") {
            $purchases=Purchase::where('supplier_id',$this->supplier_id)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id','ASC')
                ->get();

        }else{
            $purchases=[];

        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }
        $suppliers=Supplier::all();


        return view('livewire.admin-supplier-report-component',['branches'=>$branches,'suppliers'=>$suppliers,'purchases'=>$purchases])->layout('layouts.admin');
    }
}
