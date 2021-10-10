<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\GeneralSetting;
use App\Models\Sale;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class AdminUnitSalesReportComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $branch_id;
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
        $this->resetPage();
        $this->date_to="";
    }
    public function updatedDateTo(){
        $this->reportReady=$this->CheckReportReadyStatus();
        $this->resetPage();
    }

    private function CheckReportReadyStatus()
    {
        if ($this->date_from!=="" && $this->date_to!==null && $this->branch_id!==null) {
            return true;
        }else{
            return false;
        }
    }

    public function downloadPDF(){
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $AdminBranchId=auth()->user()->branch_id;

        if ($this->branch_id!=="" && $this->date_from!=="" && $this->date_to!=="") {
            $sales=Sale::where('reversed',0)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->get();
            $units=[];

            foreach ($sales as $key=>$placed_sale) {
                foreach (unserialize($placed_sale->sale) as $another_key=> $product){
                    $product_sale=[
                        $product['size_id']=>[
                            'sku'=>$product['sku'],
                            'product_name'=>$product['product_name'],
                            'size_name'=>$product['size'],
                            'quantity'=>$product['quantity'],
                        ]
                    ];
                    $units[] = $product_sale;

                }
            }

            $sales=collect($units)
                ->groupBy(function ($item) {
                    return array_key_first($item);
                });

        }else{
            $sales=[];
        }

        $branch=Branch::find($this->branch_id)->name;

        $settingsCount = GeneralSetting::all()->count();
        if ($settingsCount == 0) {
            $logo = 'null';
        } else {
            $logo = GeneralSetting::first()->logo;
        }
        (new LogsService('downloaded unit sales rpt','Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.unit_sales', compact(['sales','branch', 'from', 'to','logo']))->output();
        return response()->streamDownload(
            fn() => print($pdfContent),
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

        if ($this->branch_id!=="" && $this->date_from!=="" && $this->date_to!=="") {
            $sales=Sale::where('reversed',0)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->get();
            $units=[];

            foreach ($sales as $key=>$placed_sale) {
                foreach (unserialize($placed_sale->sale) as $another_key=> $product){
                        $product_sale=[
                            $product['size_id']=>[
                                'sku'=>$product['sku'],
                                'product_name'=>$product['product_name'],
                                'size_name'=>$product['size'],
                                'quantity'=>$product['quantity'],
                            ]
                        ];
                        $units[] = $product_sale;

                }
            }

            $sales=collect($units)
                ->groupBy(function ($item) {
                    return array_key_first($item);
                });

        }else{
            $sales=[];
        }

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }
        return view('livewire.admin-unit-sales-report-component',compact(['branches','sales']))->layout('layouts.admin');
    }
}
