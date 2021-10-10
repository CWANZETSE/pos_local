<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\CashPayment;
use App\Models\Declarations;
use App\Models\GeneralSetting;
use App\Models\Sale;
use App\Models\User;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PDF;

class AdminCashierReconcileComponent extends Component
{
    public $users=[];
    public $user_id;
    public $branch_id;
    public $date_from;
    public $reportReady=false;
    public $ifBalanced=false;

    public function mount(){
        $this->user_id="";
        $this->reportReady=false;
    }

    public function updatedBranchId(){
        $this->users=User::where('branch_id',$this->branch_id)->get();
        $this->date_from="";
        $this->reportReady=false;
    }
    public function updatedUserId(){
        $this->date_from="";
        $this->reportReady=false;
    }
    public function updatedDateFrom(){
        $this->reportReady=true;
    }
    public function PrintRunningDeclarations(){
        $user_id=$this->user_id;
        $date_from=$this->date_from;

        $from  = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to    = Carbon::parse($date_from)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $declarations=Declarations::with('branch')
            ->with('user')
            ->with('admin')
            ->where('user_id',$this->user_id)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        $branch=Branch::find($this->branch_id)->name;
        $cashier=User::where('id',$this->user_id)->first()->name;
        $settingCount=GeneralSetting::all()->count();
        if ($settingCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }
        (new LogsService('printed declarations','Admin'))->storeLogs();

        $pdfContent = PDF::loadView('pdf.declarations',compact(['declarations','from','to','logo','branch','cashier']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "declarations.pdf"
        );
    }
    public function render()
    {
        $AdminBranchId=auth()->user()->branch_id;
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_from)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!="" && $this->user_id!="" && $this->branch_id!="") {
            $pendingDeclarationsSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_PENDING)
                ->where('float',0)
                ->sum('amount');
            $approvedDeclarationsSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_APPROVED)
                ->where('float',0)
                ->sum('amount');
            $declinedDeclarationsSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_REJECTED)
                ->where('float',0)
                ->sum('amount');
            $totalCashSales=CashPayment::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->where('reversed',CashPayment::IS_NOT_REVERSED)
                ->whereBetween('created_at', [$from, $to])
                ->sum('total');
            $pendingFloatSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_PENDING)
                ->where('float',1)
                ->sum('amount');
            $approvedFloatSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_APPROVED)
                ->where('float',1)
                ->sum('amount');
            $approvedExpensesSum=Declarations::where('user_id',$this->user_id)
                ->where('branch_id',$this->branch_id)
                ->whereBetween('created_at', [$from, $to])
                ->where('status',Declarations::IS_APPROVED)
                ->where('destination','expense')
                ->sum('amount');
            $netCash=$approvedDeclarationsSum-$approvedExpensesSum;
            $expectedNetCash=$totalCashSales-$approvedExpensesSum;

            if ($totalCashSales==$approvedDeclarationsSum && $pendingFloatSum==0){
                $this->ifBalanced=true;
            }else{
                $this->ifBalanced=false;
            }
        }else{
            $pendingDeclarationsSum=0;
            $approvedDeclarationsSum=0;
            $declinedDeclarationsSum=0;
            $totalCashSales=0;
            $pendingFloatSum=0;
            $approvedFloatSum=0;
            $approvedExpensesSum=0;
            $netCash=0;
            $expectedNetCash=0;
            $this->ifBalanced=false;
        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }
        return view('livewire.admin-cashier-reconcile-component',compact(['branches','pendingDeclarationsSum','approvedDeclarationsSum','declinedDeclarationsSum','totalCashSales','pendingFloatSum','approvedFloatSum','approvedExpensesSum','netCash','expectedNetCash','AdminBranchId']))->layout('layouts.admin');
    }
}
