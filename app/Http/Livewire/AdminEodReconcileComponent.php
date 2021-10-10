<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\CardPayment;
use App\Models\CashPayment;
use App\Models\Declarations;
use App\Models\GeneralSetting;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use App\Services\LogsService;
use PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AdminEodReconcileComponent extends Component
{
    public $branch_id;
    public $date_from;
    public $reportReady=false;
    public $ifBalanced=false;


    public function updatedBranchId(){
        $this->date_from="";
        $this->reportReady=false;
    }
    public function updatedDateFrom(){
        $this->reportReady=$this->CheckReportReadyStatus();
    }

    private function CheckReportReadyStatus()
    {
        if ($this->date_from!==null && $this->branch_id!==null) {
            return true;
        }else{
            return false;
        }
    }
    public function downloadPDF(){
        $date_from=$this->date_from;
        $branch_id=$this->branch_id;
        $from = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_from)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $branch=Branch::findOrFail($this->branch_id)->name;


        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $headerLogo='null';
        }else{
            $headerLogo=GeneralSetting::first()->logo;
        }
        if ($this->date_from!="" && $this->branch_id!="") {

            $declarations = Declarations::select([
                'user_id',
                'status',
                'admin_id',
                'float',
                DB::raw('COUNT(id) as transactions'),
                DB::raw('SUM(amount) as amount')
            ])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->with('user')
                ->with('admin')
                ->groupBy('user_id')
                ->groupBy('admin_id')
                ->groupBy('status')
                ->groupBy('float')
                ->get();
            $cashiersDeclarations = Declarations::select([
                'user_id',
                'status',
                'float',
                DB::raw('SUM(amount) as amount')
            ])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->with('user')
                ->groupBy('user_id')
                ->groupBy('status')
                ->groupBy('float')
                ->get();
            $managersDeclarations = Declarations::select([
                'status',
                'admin_id',
                DB::raw('SUM(amount) as amount')
            ])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->where('float',0)
                ->with('admin')
                ->groupBy('admin_id')
                ->groupBy('status')
                ->get();
            $totalUserCashSales = CashPayment::select([
                'user_id',
                DB::raw('SUM(total) as amount')
            ])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->with('user')
                ->groupBy('user_id')
                ->get();
            $totalUserCardSales = CardPayment::select(['user_id',DB::raw('SUM(TransactionAmount) as TransactionAmount')])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->with('user')
                ->groupBy('user_id')
                ->get();
            $CashSalesAmount=CashPayment::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->sum('total');
            $CardSalesAmount=CardPayment::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->sum('TransactionAmount');
            $admins=Admin::where('branch_id',null)->orWhere('branch_id',$this->branch_id)->get();
            $cashpay_ids=[];
            $cash_payments=CashPayment::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->get();
            foreach($cash_payments as $payment){
                $cashpay_ids[] = $payment->sale_id;
            }
            $sales=Sale::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->where('reversed',Sale::IS_REVERSED)
                ->get();
            $totalCashReversed=0;
            $totalCardReversed=0;
            foreach($sales as $sale){
                $totalCashReversed+=CashPayment::where('sale_id',$sale->id)->sum('total');
                $totalCardReversed+=CardPayment::where('sale_id',$sale->id)->sum('TransactionAmount');
            }
            $cardpay_ids=[];
            $card_payments=CardPayment::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->get();
            foreach($card_payments as $payment){
                $cardpay_ids[] = $payment->sale_id;
            }

            $branch_sales=Sale::whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->where('reversed',Sale::IS_REVERSED)
                ->get();

        }else{

            $declarations=[];
            $cashiersDeclarations=[];
            $managersDeclarations=[];
            $totalUserCashSales=[];
            $totalUserCardSales=[];
            $admins=[];
            $branch_sales=[];
            $cashpay_ids=[];
            $cardpay_ids=[];
            $CashSalesAmount=0;
            $CardSalesAmount=0;
            $totalCashReversed=0;
            $totalCardReversed=0;

        }
        (new LogsService('printed eod report','Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.endofday',compact(['totalUserCardSales','declarations','branch','from','to','headerLogo','totalCashReversed','totalCardReversed','cashiersDeclarations','managersDeclarations','branch_id','totalUserCashSales','admins','branch_sales','cashpay_ids','cardpay_ids','CashSalesAmount','CardSalesAmount']))->output();
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
        $to      = Carbon::parse($this->date_from)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!="" && $this->branch_id!="") {

            $declarations = Declarations::select([
                                'user_id',
                                'status',
                                'admin_id',
                                'float',
                                DB::raw('COUNT(id) as transactions'),
                                DB::raw('SUM(amount) as amount')
                            ])
                            ->whereBetween('created_at', [$from, $to])
                            ->where('branch_id',$this->branch_id)
                            ->with('user')
                            ->with('admin')
                            ->groupBy('user_id')
                            ->groupBy('admin_id')
                            ->groupBy('status')
                            ->groupBy('float')
                            ->get();
            $totalUserCashSales = CashPayment::select(['user_id',DB::raw('SUM(total) as amount')])
                                ->whereBetween('created_at', [$from, $to])
                                ->where('branch_id',$this->branch_id)
                                ->where('reversed',CashPayment::IS_NOT_REVERSED)
                                ->with('user')
                                ->groupBy('user_id')
                                ->get();
            $totalUserCardSales = CardPayment::select(['user_id',DB::raw('SUM(TransactionAmount) as TransactionAmount')])
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$this->branch_id)
                ->with('user')
                ->groupBy('user_id')
                ->get();



        }else{

            $declarations=[];
            $totalUserCashSales=[];
            $totalUserCardSales=[];
        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }
        return view('livewire.admin-eod-reconcile-component',compact(['branches','declarations','totalUserCashSales','totalUserCardSales']))->layout('layouts.admin');
    }
}
