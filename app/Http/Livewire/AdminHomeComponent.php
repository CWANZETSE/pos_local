<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use DB;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\CashPayment;
use App\Models\Mpesa;
use App\Models\CardPayment;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class AdminHomeComponent extends Component
{
	public $SalesToday;
	public $SalesThisWeek;
    public $stores;
    public $cashToday;
    public $cardToday;
    public $salesReturn;
    public $mpesaToday;
    public $salesToday;
    public $pending_invoices_count;
    public $pending_orders_count;

    public $types = ['food', 'shopping', 'entertainment', 'travel', 'other'];
    public $colors = [
        'food' => '#f6ad55',
        'shopping' => '#fc8181',
        'entertainment' => '#90cdf4',
        'travel' => '#66DA26',
        'other' => '#cbd5e0',
    ];
    public $firstRun = true;
    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];

	public function mount(){
		$this->SalesToday=0;
		$this->SalesThisWeek=0;
		$this->getReportingData();
	}

	public function ViewPendingInvoiceModal(){
        $this->dispatchBrowserEvent('ViewPendingInvoiceModalEvent');
    }

    public function ViewPendingOrdersModal(){
        $this->dispatchBrowserEvent('ViewPendingOrdersModalEvent');
    }

    private function getReportingData()
    {
        $days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $this->dispatchBrowserEvent('TestEvent', ['days' => $days]);
    }

    public function render()
    {
        $AdminBranchId = auth()->user()->branch_id;

        $startOfWeek = Carbon::now()
            ->startOfWeek()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $startOfToday = Carbon::now()
            ->startOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $endOfToday = Carbon::now()
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $pendingInvoicesQuery = Purchase::with('branch')
            ->with('supplier')
            ->where('canceled',0)
            ->where('payment_status',Purchase::IS_PENDINGINVOICE);
        if (Auth::user()->role_id == Admin::IS_MANAGER) {
            $pendingInv=$pendingInvoicesQuery->where('branch_id', $AdminBranchId)->get();
        }else{
            $pendingInv=$pendingInvoicesQuery->get();
        }


        $pendingOrdersQuery = Order::with('branch')
            ->with('supplier')
            ->select([
                'order_id',
                'branch_id',
                'supplier_id',
                'created_at',
                'status',
                'order_total',
                \Illuminate\Support\Facades\DB::raw('COUNT(id) as transactions'),
            ])
            ->groupBy([
                'order_id',
                'branch_id',
                'supplier_id',
                'created_at',
                'status',
                'order_total',
            ])
            ->where('status',Order::IS_PENDING);
        if (Auth::user()->role_id == Admin::IS_MANAGER) {
            $pendingOrders=$pendingOrdersQuery->where('branch_id', $AdminBranchId)->get();
        }else{
            $pendingOrders=$pendingOrdersQuery->get();
        }








             $salesThisWeekR=Sale::where('reversed',0)
                 ->whereBetween('created_at', [$startOfWeek, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $salesThisWeek=$salesThisWeekR->where('branch_id',$AdminBranchId)->sum('total');
                    }else{
                        $salesThisWeek=$salesThisWeekR->sum('total');
                    }
             $today_salesR=Sale::where('reversed',0)
                 ->whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $today_sales=$today_salesR->where('branch_id',$AdminBranchId)->sum('total');
                    }else{
                        $today_sales=$today_salesR->sum('total');
                    }


                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $stores=Branch::where('id',$AdminBranchId)->count();
                    }else{
                        $stores=Branch::all()->count();
                    }
             $cashTodayR=CashPayment::where('reversed',0)->whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $cashToday=$cashTodayR->where('branch_id',$AdminBranchId)->count();
                    }else{
                        $cashToday=$cashTodayR->count();
                    }
             $mpesaTodayR=Mpesa::whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $mpesaToday="Check EOD Report";
                    }else{
                        $mpesaToday=$mpesaTodayR->count();
                    }
             $cardTodayR=CardPayment::where('reversed',0)->whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $cardToday=$cardTodayR->where('branch_id',$AdminBranchId)->count();
                    }else{
                        $cardToday=$cardTodayR->count();
                    }
             $salesReturnR=Sale::where('reversed',1)->whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $salesReturn=$salesReturnR->where('branch_id',$AdminBranchId)->count();
                    }else{
                        $salesReturn=$salesReturnR->count();
                    }
             $salesTodayR=Sale::where('reversed',0)->whereBetween('created_at', [$startOfToday, $endOfToday]);
                    if (Auth::user()->role_id==Admin::IS_MANAGER){
                        $salesToday=$salesTodayR->where('branch_id',$AdminBranchId)->count();
                    }else{
                        $salesToday=$salesTodayR->count();
                    }


             $this->SalesToday=$today_sales;
             $this->SalesThisWeek=$salesThisWeek;
                $this->stores=$stores;
                $this->cashToday=$cashToday;
                $this->cardToday=$cardToday;
                $this->salesReturn=$salesReturn;
                $this->mpesaToday=$mpesaToday;
                $this->salesToday=$salesToday;


                $this->pending_invoices_count=Purchase::all()->count()>0?Purchase::where('payment_status',0)->distinct()->count('invoice_id') :0;
                $this->pending_orders_count=Order::all()->count()>0?Order::where('status',0)->count() :0;

             $salesReturnThisWeek=Sale::where('reversed',1)->whereBetween('created_at', [$startOfWeek, $endOfToday])->sum('total');
             $today_sales_return=Sale::where('reversed',1)->whereBetween('created_at', [$startOfToday, $endOfToday])->sum('total');

        return view('livewire.admin-home-component',compact(['pendingInv','pendingOrders']))->layout('layouts.admin');
    }


}
