<?php

namespace App\Http\Livewire;

use App\Models\GeneralSetting;
use App\Models\Supplier;
use App\Models\SupplierHistory;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class AdminSupplierHistoryComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $supplier_code;
    public $date_from;
    public $date_to;
    public $perPage;
    public $reportReady;
    public $supplier_name;
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
        $this->reportReady= !($this->supplier_code === null) && !($this->supplier_code === "");
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

    public function updatedSupplierCode(){
        $this->date_from="";
        $this->date_to="";
        $this->reportReady=false;
        $this->supplier_name=Supplier::where('supplier_code',$this->supplier_code)->first()?Supplier::where('supplier_code',$this->supplier_code)->first()->name:'';
    }

    private function CheckReportReadyStatus()
    {
        if ($this->date_from!=="" && $this->date_to!=="" && $this->supplier_code!=="") {
            return true;
        }else{
            return false;
        }
    }

    public function downloadPDF(){
        $supplier_name=Supplier::where('supplier_code',$this->supplier_code)->first()?Supplier::where('supplier_code',$this->supplier_code)->first()->name:'';
        $supplier_code=$this->supplier_code;
        $date_from=$this->date_from;
        $date_to=$this->date_to;
        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if($supplier_name){
            if ($this->date_from!=="" && $this->date_to!=="" && $this->supplier_code!=="") {
                $histories=SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->get();
                $sumMoneyOut=SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->latest()->first()?SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->sum('money_out'):0;
                $sumMoneyIn=SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->latest()->first()?SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->sum('money_in'):0;
                $finalBalance=SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->latest()->first()?SupplierHistory::where('supplier_code',$this->supplier_code)
                    ->whereBetween('created_at', [$from, $to])
                    ->latest()->first()->balance:0;
                $settingsCount=GeneralSetting::all()->count();
                if ($settingsCount==0) {
                    $logo='null';
                }else{
                    $logo=GeneralSetting::first()->logo;
                }
                (new LogsService('downloaded supplier hist statm','Admin'))->storeLogs();
                $pdfContent = PDF::loadView('pdf.supplierHistoryStatement',compact(['histories','supplier_name','supplier_code','sumMoneyIn','sumMoneyOut','finalBalance','logo','from','to']))->output();
                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "supplier_statement.pdf"
                );
            }
        }
        $histories=[];
    }
    public function render()
    {
        $date_from=$this->date_from;
        $date_to=$this->date_to;
        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!=="" && $this->date_to!=="") {
            $histories=SupplierHistory::where('supplier_code',$this->supplier_code)
                ->whereBetween('created_at', [$from, $to])
                ->paginate($this->perPage);
        }else{
            $histories=[];
        }
        return view('livewire.admin-supplier-history-component',compact(['histories']))->layout('layouts.admin');
    }
}
