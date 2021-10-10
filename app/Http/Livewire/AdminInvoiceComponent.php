<?php
namespace App\Http\Livewire;
require_once __DIR__ . '/../../../vendor/dompdf/dompdf/lib/Cpdf.php';

use App\Models\Admin;
use App\Models\Declarations;
use App\Models\Order;
use App\Models\Profit;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierBank;
use App\Models\SupplierHistory;
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


class AdminInvoiceComponent extends Component
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
    public $InvoiceData=[];
    public $SingleInvoice=[];

    public $pay_invoice_id;
    public $pay_supplier_name;
    public $pay_amount;
    public $pay_bank_id;
    public $pay_account_number;
    public $pay_bank_transaction_id;
    public $supplier_bank_data=[];

    public $search_type;
    public $viewFilters;
    public $searchCode;
    public $searchCodeSelected;
    public $selectedPeriod="Select date from options";



    public function mount(){
        $this->reportReady=false;
        $this->searchCodeSelected=false;
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
        $this->date_from="";
        $this->date_to="";
        $this->reportReady=$this->CheckReportReadyStatus();
    }
    public function updatedDateFrom(){
        $this->reportReady=$this->CheckReportReadyStatus();
        $this->date_to="";
    }
    public function updatedDateTo(){
        $this->reportReady=$this->CheckReportReadyStatus();
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

        $invoicesQuery=Purchase::with('branch')
            ->with('supplier')
            ->with('branch')
            ->where('branch_id',$this->branch_id)
            ->where('canceled',0)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_status',$this->status_id);

        if($this->supplier_id==0){
            $invoices=$invoicesQuery->get();
        }else{
            $invoices=$invoicesQuery->where('supplier_id',$this->supplier_id)->get();
        }
        $branch=Branch::where('id',$this->branch_id)->first()->name;
        (new LogsService('downloaded invoice statement' ,'Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.invoiceStatement',compact(['from','to','branch','invoices','logo']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );


    }


    private function CheckReportReadyStatus()
    {
        if ($this->date_from!==null && $this->date_to!=="" && $this->branch_id!=="" && $this->supplier_id!=="" && $this->status_id!=="") {
            return true;
        }else{
            return false;
        }
    }

    public function SubmitInvoicePaymentModal($invoiceId){

        $invoice=Purchase::where('invoice_id',$invoiceId)->first();

        $amount=0;
        foreach(unserialize($invoice->order_data) as $key=>$data){
            $amount+=$data['cost']*$data['stock'];
        }
        $this->pay_account_number="";
        $supplier=$invoice->supplier;
        $this->supplier_bank_data=$invoice->supplier->supplierBanks;
        $this->pay_invoice_id=$invoiceId;
        $this->pay_supplier_name=$supplier->name;
        $this->pay_amount=number_format($amount,2);
        $this->dispatchBrowserEvent('ShowInvoicePayModalEvent');
    }
    public function updatedPayBankId(){
        $this->pay_account_number=SupplierBank::find($this->pay_bank_id)?SupplierBank::find($this->pay_bank_id)->account_number:'';
    }
    public function SubmitInvoicePayment(){
        $invoice=Purchase::where('invoice_id',$this->pay_invoice_id)->first();
        $validatedData = $this->validate([
            'pay_bank_id'=>'required',
            'pay_account_number'=>'required',
            'pay_bank_transaction_id'=>'required',
        ]);

        $invoice->update([
            'payment_status'=>1,
            'paid_on'=>Carbon::now(),
            'paid_by'=>auth()->user()->id,
            'payment_id'=>mt_rand(100000000,999999999),
            'account_number'=>SupplierBank::find($this->pay_bank_id)->account_number,
            'bank_name'=>SupplierBank::find($this->pay_bank_id)->bank_name,
            'bank_transaction_id'=>$this->pay_bank_transaction_id,
        ]);


        $order_data=$invoice->order_data;

        $total=0;

        foreach(unserialize($order_data) as $data){
            $total+=($data['cost']*$data['stock']);
        }

        $branch=Branch::find($invoice->branch_id)->name;
        $history=SupplierHistory::count();
        $supplier_code=Supplier::find($invoice->supplier_id)->supplier_code;
        if($history==0){
            $balance=0+$total;
        }else{
            $balance=SupplierHistory::where('supplier_code',$supplier_code)->latest()->first()?SupplierHistory::where('supplier_code',$supplier_code)->latest()->first()->balance+$total:0+$total;
        }
        SupplierHistory::create([
            'supplier_code'=>$supplier_code,
            'invoice_id'=>$invoice->invoice_id,
            'description'=>'Pay Supply Order '.$invoice->order_id.' '.$branch,
            'money_in'=>$total,
            'balance'=>$balance,
        ]);

        $order_id=Purchase::where('invoice_id',$this->pay_invoice_id)->first()->order_id;
        $order=Order::where('order_id',$order_id)->first();
        $order->update([
           'paid_on'=> Carbon::now(),
        ]);
        $this->pay_account_number="";
        $this->pay_bank_name="";
        $this->pay_bank_transaction_id="";
        $this->dispatchBrowserEvent('HideInvoicePayModalEvent');
        (new LogsService('paid invoice'.$invoice->invoice_id ,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successEvent',['message'=>'Payment was Successful','type'=>'success']);
    }


    public function ViewInvoiceModal($invoiceId){
        $this->InvoiceData=Purchase::with('branch')->with('supplier')->where('invoice_id',$invoiceId)->get();
        $this->SingleInvoice=Purchase::with('branch')->with('supplier')->where('invoice_id',$invoiceId)->first();
        $this->dispatchBrowserEvent('ShowInvoiceViewModalEvent');
    }

    public function DownloadInvoice($invoiceId){
        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $logo='null';
        }else{
            $logo=GeneralSetting::first()->logo;
        }
        $invoiceData=Purchase::with('branch')
            ->with('supplier')
            ->where('invoice_id',$invoiceId)
            ->first();
        $invoiceFirstRowData=Purchase::with('branch')
            ->with('supplier')
            ->where('invoice_id',$invoiceId)
            ->first();

        (new LogsService('downloaded invoice' ,'Admin'))->storeLogs();
        $pdfContent = PDF::loadView('pdf.invoice',compact(['invoiceData','invoiceFirstRowData','logo']))->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );
    }
    public function render()
    {
        $this->CheckReportReadyStatus();
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if($this->search_type=="code"){
            $purchases=Purchase::all()->count()>0?Purchase::
                with('branch')
                ->with('supplier')
                ->where('invoice_id', $this->searchCode)
                ->get():[];
            $this->searchCodeSelected=true;
        }else {
            if ($this->date_from !=="" && $this->date_to !=="" && $this->branch_id !=="" && $this->supplier_id !=="" && $this->status_id !=="") {
                $this->searchCodeSelected=false;
                $query = Purchase::with('branch')
                    ->with('supplier')
                    ->where('branch_id', $this->branch_id)
                    ->where('canceled', 0);

                if ($this->supplier_id == 0) {
                    if ($this->status_id == 1) {
                        $purchases = $query->where('payment_status', $this->status_id)->whereBetween('paid_on', [$from, $to])->get();
                    } else {
                        $purchases = $query->where('payment_status', $this->status_id)->whereBetween('created_at', [$from, $to])->get();
                    }

                } else {
                    if ($this->status_id == 1) {
                        $purchases = $query->where('payment_status', $this->status_id)->whereBetween('paid_on', [$from, $to])->where('supplier_id', $this->supplier_id)->get();
                    } else {
                        $purchases = $query->where('payment_status', $this->status_id)->whereBetween('created_at', [$from, $to])->where('supplier_id', $this->supplier_id)->get();
                    }
                }


            } else {
                $purchases = [];
            }
        }
        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',Auth::user()->branch_id)->get();
        }else{
            $branches=Branch::all();
        }
        $suppliers=Supplier::where('status',1)->get();

        return view('livewire.admin-invoice-component',compact(['branches','purchases','suppliers']))->layout('layouts.admin');
    }

}
