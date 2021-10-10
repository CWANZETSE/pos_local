<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Services\LogsService;
use PDF;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\GeneralSetting;
use App\Models\SalesReturn;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;


class AdminCashierReportComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $user_id;
	public $date_from;
	public $date_to;
	public $perPage;
	public $reportReady;
	public $printMode;
	public $selectedSaleId;
	public $SingleSale=null;
    public $selectedPeriod="Select date from options";


	public function mount(){
		$this->user_id="";
		$this->reportReady=false;
		$this->perPage=10;
	}

    public function ShowDateRangeModal(){
        $this->dispatchBrowserEvent('ShowDateRangeModalEvent');
    }
    public function PredefinedPeriod($str){
        $this->reportReady= !($this->user_id === null) && !($this->user_id === "");
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

	public function updatedUserId(){
		$this->date_from="";
		$this->date_to="";
        $this->resetPage();
		$this->reportReady=false;
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
        if ($this->date_from!==null && $this->date_to!==null && $this->user_id!==null) {
            return true;
        }else{
            return false;
        }
    }

	public function ViewSaleModal($saleId){
		$this->SingleSale=Sale::findOrFail($saleId);
		$this->dispatchBrowserEvent('ShowCashierSalesModalEvent');
	}

	public function downloadPDF(){


			$user_id=$this->user_id;
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
	                     ->where('user_id',$this->user_id)
	                     ->where('reversed',0)
	                     ->whereBetween('created_at', [$from, $to])
	                     ->get();

	        $cashier=User::findOrFail($this->user_id)->first()->name;
	        $reversed_amount=Sale::where('user_id',$this->user_id)
	                        ->whereBetween('created_at', [$from, $to])
	                        ->where('reversed',1)
	                        ->sum('total');

	        $settingsCount=GeneralSetting::all()->count();
	        if ($settingsCount==0) {
		        $logo='null';
	    	}else{
	    		$logo=GeneralSetting::first()->logo;
	    	}
        (new LogsService('printed cashier report','Admin'))->storeLogs();

			$pdfContent = PDF::loadView('pdf.cashier',compact(['sales','cashier','from','to','reversed_amount','logo']))->output();
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
        if ($this->date_from!="" && $this->date_to!="") {
        	$orders=Sale::with('branch')
                 ->with('user')
                 ->where('user_id',$this->user_id)
                 ->whereBetween('created_at', [$from, $to])
                 ->paginate($this->perPage);
	    	$users=User::all();
	    	$count=Sale::with('branch')
                 ->with('user')
                 ->where('user_id',$this->user_id)
                 ->whereBetween('created_at', [$from, $to])
                 ->get()
                 ->count();
        }else{
        	$orders=[];
	    	$users=User::all();
	    	$count=0;
        }

        return view('livewire.admin-cashier-report-component',['users'=>$users,'sales'=>$orders,'count'=>$count])->layout('layouts.admin');
    }
}
