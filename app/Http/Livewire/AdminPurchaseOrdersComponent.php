<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Models\Declarations;
use App\Models\Order;
use App\Models\Profit;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use App\Services\CalculateProfitService;
use App\Services\CreateOrUpdateAttributesService;
use App\Services\LogsService;
use App\Services\OrderCreateService;
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


class AdminPurchaseOrdersComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $branch_id;
    public $supplier_id;
    public $status_id;
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
    public $mac_address;
    public $ip_address;
    public $items=[];
    public $orderData=[];
    public $SingleOrder=[];


    public $orderId;
    public $decision_id="";

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
        $this->resetPage();
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
        $this->reportReady=$this->CheckReportReadyStatus();
    }
    public function updatedSupplierId(){
        $this->date_from="";
        $this->date_to="";
        $this->reportReady=$this->CheckReportReadyStatus();
    }
    public function updatedStatusId(){
        $this->reportReady=$this->CheckReportReadyStatus();
    }
    public function updatedDateFrom(){
        $this->reportReady=$this->CheckReportReadyStatus();
        $this->date_to="";
    }
    public function updatedDateTo(){
        $this->reportReady=$this->CheckReportReadyStatus();
    }


    public function downloadPDFStatement(){
        $branch_id=$this->branch_id;
        $date_from=$this->date_from;
        $date_to=$this->date_to;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }

        $Query=Order::with('branch')
            ->with('supplier')
            ->whereBetween('created_at', [$from, $to])
            ->where('status',$this->status_id);

        if($this->supplier_id==0){
            //supplier_id== 0 means all Suppliers selected
            $orders=$Query->get();
        }else{
            $orders=$Query->where('supplier_id',$this->supplier_id)->get();
        }
        $branch=Branch::where('id',$this->branch_id)->first()->name;
        (new LogsService('downloaded order statement' ,'Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.orderStatement',compact(['from','to','branch','orders','logo']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );


    }


    private function CheckReportReadyStatus()
    {
        if ($this->date_from!=="" && $this->date_to!=="" && $this->branch_id!="" && $this->supplier_id!="" && $this->status_id!="") {
            return true;
        }else{
            return false;
        }
    }

    public function OrderActionModal($orderId){
        $this->orderId=$orderId;
        $this->dispatchBrowserEvent('ShowOrderActionModalEvent');
    }
    public function SelectOrderDecisionFromModal(){
        if($this->decision_id==Order::IS_DECLINED){
            $order=Order::find($this->orderId);
            $order->update([
                'status'=>Order::IS_DECLINED,
            ]);
            $this->orderId="";
            $this->decision_id="";
            $this->searchCode="";
            $this->dispatchBrowserEvent('successEvent',['message'=>'Purchase Order Declined Successfully','type'=>'success']);
            $this->dispatchBrowserEvent('HideOrderActionModalEvent');
        }else{
            (new OrderCreateService())->StorePurchaseItems($this->orderId);
            (new CreateOrUpdateAttributesService())->StoreAttributesParams($this->orderId);
            $order=Order::find($this->orderId);
            $order->update([
                'status'=>Order::IS_APPROVED,
            ]);
            $this->orderId="";
            $this->decision_id="";
            $this->dispatchBrowserEvent('successEvent',['message'=>'Purchase Order Approved Successfully','type'=>'success']);
            $this->dispatchBrowserEvent('HideOrderActionModalEvent');
        }


    }



    public function ViewOrderModal($orderId){
        $this->orderData=Order::with('branch')->with('supplier')->where('id',$orderId)->first();
        $this->dispatchBrowserEvent('ShowOrderViewModalEvent');
    }

    public function DownloadOrder($orderId){
        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }
        $orderData=Order::with('branch')
            ->with('supplier')
            ->where('id',$orderId)
            ->first();

        $pdfContent = PDF::loadView('pdf.order',compact(['orderData','logo']))->output();
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

        if($this->search_type=="code"){
            $purchases=Order::all()->count()>0?Order::with('branch')
                ->with('supplier')->where('order_id',$this->searchCode)->get():[];
        }else{
            if ($this->date_from!=="" && $this->date_to!=="" && $this->branch_id!=="" && $this->supplier_id!=="" && $this->status_id!=="") {
                $query=Order::with('branch')
                    ->with('supplier');
                if($this->supplier_id==0){
                    if($this->status_id==1){
                        $purchases=$query->where('status',$this->status_id)->whereBetween('updated_at', [$from, $to])->get();
                    }else{
                        $purchases=$query->where('status',$this->status_id)->whereBetween('created_at', [$from, $to])->get();
                    }

                }else{
                    if($this->status_id==1) {
                        $purchases = $query->where('status',$this->status_id)->whereBetween('paid_on', [$from, $to])->where('supplier_id', $this->supplier_id)->get();
                    }else{
                        $purchases = $query->where('status',$this->status_id)->whereBetween('created_at', [$from, $to])->where('supplier_id', $this->supplier_id)->get();
                    }
                }


            }else{
                $purchases=[];
            }
        }

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',Auth::user()->branch_id)->get();
        }else{
            $branches=Branch::all();
        }
        $suppliers=Supplier::where('status',1)->get();

        return view('livewire.admin-purchase-orders-component',compact(['branches','purchases','suppliers']))->layout('layouts.admin');
    }

}
