<?php

namespace App\Http\Livewire;

use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use App\Models\Profit;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Branch;
use Livewire\WithPagination;
use PDF;

class AdminProfitsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $branch_id;
    public $date_from;
    public $date_to;
    public $perPage;
    public $reportReady;
    public $printMode;



    public function mount(){
        $this->branch_id="";
        $this->reportReady=false;
        $this->perPage=5;
    }

    public function updatedBranchId(){
        $this->date_from="";
        $this->date_to="";
        $this->reportReady=false;
    }
    public function updatedDateFrom(){
        $this->reportReady=false;
        $this->date_to="";
    }
    public function updatedDateTo(){
        $this->reportReady=true;
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
        $profits=Profit::with('branch')
            ->where('branch_id',$this->branch_id)
            ->where('canceled',0)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        $branch=Branch::findOrFail($branch_id)->first()->name;


        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }

        $pdfContent = PDF::loadView('pdf.profits',compact(['profits','branch','from','to','logo']))->output();
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
            $profits=Profit::with('branch')
                ->where('branch_id',$this->branch_id)
                ->where('reversed',0)
                ->whereBetween('created_at', [$from, $to])
                ->paginate($this->perPage);
            $branches=Branch::all();
            $count=Profit::with('branch')
                ->where('branch_id',$this->branch_id)
                ->where('reversed',0)
                ->whereBetween('created_at', [$from, $to])
                ->get()
                ->count();
        }else{
            $profits=[];
            $branches=Branch::all();
            $count=0;
        }
        return view('livewire.admin-profits-component',['branches'=>$branches,'profits'=>$profits,'count'=>$count])->layout('layouts.admin');
    }
}
