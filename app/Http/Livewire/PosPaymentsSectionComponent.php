<?php

namespace App\Http\Livewire;
use App\Models\CardPayment;
use App\Models\Declarations;
use App\Models\GeneralSetting;
use App\Models\Setting;
use App\Models\User;
use App\Services\CardPaymentService;
use App\Services\CashierUndeclaredCashService;
use App\Services\CashPaymentService;
use App\Services\LogsService;
use App\Services\Mike42CardReceiptReprintService;
use App\Services\Mike42CashReceiptReprintService;
use App\Services\Mike42CustomerReceiptService;
use App\Services\Mike42CashierReceiptService;
use App\Services\MpesaService;
use App\Services\PrintCashierDepositVoucherService;
use App\Services\PrintCashierTransactionSummaryService;
use App\Services\PrintCashReceiptService;
use App\Services\PrintReceiptService;
use App\Services\SaleRunningStockService;
use App\Services\StoreParamsService;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

use App\Models\ProductsAttribute;
use App\Models\Sale;
use App\Models\CashPayment;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\CalculateProfitService;
use App\Services\PlaceSaleForAllPaymentModesService;

use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class PosPaymentsSectionComponent extends Component
{
	public $totalBill=0;
	public $cashPay;
	public $change;
	public $user;
	public $readyForCashPayment;
	public $saleId;
	public $receipt;
	public $hasSession;
	public $phone_number;
	public $responseCode;
	public $responseMsg;
	public $ifCardPaySuccess;
	public $paymentMode;
	public $hold_release_bill;
	public $sales_allowed_reprint=[];
    public $state=[];
    public $successMsg=false;
    public $zeroErrorMsg=false;
    public $maximumErrorMsg=false;
    public $undeclared;
    public $numOfHeldProducts=0;
    public $confirmPassword;
    public $shift_closed;
    public $perpage=10;


	protected $listeners = [
		'totalAmountEvent'=>'updateTotalBillAmount',
		'TotalBillForSuspendedOrderEvent'=>'TotalBillForSuspendedOrder',
        'CloseShiftEvent'=>'CloseShift',
	];

    public function mount(){
        $pos=session()->get('pos');
        if ($pos) {
            foreach($pos as $id=>$productAttribute){
                $this->totalBill += $productAttribute['price']*$productAttribute['quantity'];
            }
        }else{
            $this->totalBill=0;
        }

        $this->change=0;
        $this->readyForCashPayment=false;

        $user=User::find(Auth::user()->id);
    }

    //HOLD RELEASE BILL
    public function updatedHoldReleaseBill(){

        if($this->hold_release_bill==="" ||$this->hold_release_bill===null){

        }else if($this->hold_release_bill==="HoldBill"){
            $this->emit('HoldBillEvent');
            $this->numOfHeldProducts=1;
        }else{
            $this->emit('ReleaseBillEvent');
            $this->numOfHeldProducts=0;
        }
    }

    public function CloseShift(){
        $user=Auth::user();
        $user->update([
            'assigned_till'=>0,
        ]);
    }


	public function showPaymentModal(){
	    if(!session()->get('pos')){
            $this->dispatchBrowserEvent('NoAddedProductsErrorModalEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
        }else{
	        if(auth()->user()->assigned_till==true){
                $this->dispatchBrowserEvent('showPaymentsModalEvent');
            }else{
                $this->dispatchBrowserEvent('TillNotAssignedErrorModalEvent');
            }

        }

    }

    public function TestIPPrinterConnection(){
        $fp = @fsockopen(auth()->user()->printer_ip,auth()->user()->printer_port, $errno, $errstr, 2);
        if ($fp === false) {
            return false;
        }else{
            return true;
        }
    }




	//======================UPDATE TOTAL BILL AMOUNT====================================


	public function updateTotalBillAmount($payload){
		$this->totalBill=$payload;
		$this->change=0.00;
		$this->cashPay="";
		$this->readyForCashPayment=false;
	}

	//=================================UPDATE CASHPAY PROPERTY===========================



	public function updatedCashPay(){
        if(strlen($this->cashPay)==0){
            $this->cashPay="";
        }
		if (strlen($this->cashPay)>0) {
			$this->calculateChange();
		}


	}
	public function setCashExactAmountToTotalBill(){
        $this->cashPay=$this->totalBill;
        $this->calculateChange();
    }

	// ===============TOTAL BILL FOR SUSPENDED ORDER=========================================
	public function TotalBillForSuspendedOrder(){
        $totalAmount=0;
        $pos=session()->get('pos');
        foreach($pos as $id=>$productAttribute){
            $totalAmount += $productAttribute['price']*$productAttribute['quantity'];
        }
        $this->totalBill=$totalAmount;
    }




	//========================================CALCULATE CHANGE=================================


	 public function calculateChange(){
         DB::transaction(function() {
             $calculatedChange = $this->totalBill - $this->cashPay;
             if ($this->cashPay > $this->totalBill + 999) {
                 $this->change = 0;
                 $this->readyForCashPayment = false;
                 $this->dispatchBrowserEvent('CashExceedsTotalErrorModalEvent');
                 shell_exec('rundll32 user32.dll,MessageBeep');
             } else if ($this->cashPay < $this->totalBill) {
                 $this->change = 0.00;
                 $this->readyForCashPayment = false;
             } else if ($this->totalBill == 0) {
                 $this->readyForCashPayment = false;
             } else {
                 $this->change = $this->cashPay - $this->totalBill;
                 $this->readyForCashPayment = true;
             }
         });
	 }

	 public function setCashPayDenomination($amount){
        if(strlen($this->cashPay)==0){
            $this->cashPay=0;
        }
        $this->cashPay+=$amount;
         if (strlen($this->cashPay)>0) {
             $this->calculateChange();
         }
     }


    //==========================SALE PLACE FOR ALL MODES====================================
    public function placeSaleForAllPaymentModes()
    {

            $SaleItems=session()->get('pos');
            $placeSale=new PlaceSaleForAllPaymentModesService($SaleItems,$this->totalBill);
            $placeSale->placingSale();
            $this->dispatchBrowserEvent('hidePaymentsModalEvent');

            $this->dispatchBrowserEvent('ModalSuccessOrderAlertEvent');

            (new LogsService('placed new sale','User'))->storeLogs();
            // END REDUCE QUANTITY FOR SKU
            $this->emit('DeleteSessionFromProductsSectionEvent');//Delete Session

    }



	 //=============================SUBMIT CASH PAYMENT======================================



	public function cashSubmitPayment(){
        DB::transaction(function()
        {
    		if ($this->readyForCashPayment && Auth::user()->status==1) {
                $this->paymentMode="cash";
    			$this->placeSaleForAllPaymentModes();
                $this->calculateProfit();
                $this->createRunningStockBalance();
    			$this->cashPaymentSave();

                $storeParams=$this->storeParams();
                $sale = Sale::where('user_id',Auth::user()->id)
                    ->latest('id')->first();

                if(auth()->user()->print_receipt===User::YES_PRINT_YES_DRAWER || auth()->user()->print_receipt===User::YES_PRINT_NO_DRAWER) {
                        if($this->TestIPPrinterConnection()===false){
                            shell_exec('rundll32 user32.dll,MessageBeep');
                            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
                            $this->totalBill=0;
                        }else{
                            (new Mike42CustomerReceiptService($this->cashPay, $this->totalBill, $this->paymentMode))->PrintIfEnabled();
                        }

                }else{
                    if(auth()->user()->print_receipt===User::NO_PRINT_YES_DRAWER){
                        if($this->TestIPPrinterConnection()===false){
                            shell_exec('rundll32 user32.dll,MessageBeep');
                            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
                        }else{
                            $connector = new NetworkPrintConnector(auth()->user()->printer_ip,auth()->user()->printer_port);
                            $printer = new Printer($connector);
                            $printer -> pulse();
                        }
                    }
                    $this->clearInputs();
                    return false;
                }
                $this->clearInputs();
                $this->readyForCashPayment=false;
                $this->paymentMode="";

    		}else{
                $this->dispatchBrowserEvent('CashPaymentErrorEvent');
                shell_exec('rundll32 user32.dll,MessageBeep');
    		}
        });
	}


    //==============STORE PARAMS=======================================

    public function storeParams(){

	    $params=new StoreParamsService();
	    return $params->getStoreParams();

    }



    //==============CASH PAYMENT SAVE==============================

    public function cashPaymentSave(){
    	$cashPay=new CashPaymentService($this->cashPay,$this->change,$this->totalBill);
    	$cashPay->saveCashPayment();
    }

    //====================CLEAR INPUTS=================================
    public function clearInputs(){
			$this->totalBill=0;
			$this->change=0;
			$this->cashPay='';
            $this->responseCode="";
            $this->responseMsg="";
            $this->ifCardPaySuccess="";
    }


    //========================ALERT MESSAGE EVENT========================================

	public function MessageAlertEvent($type,$message){
    	 $this->dispatchBrowserEvent('MessageAlertEvent', ['type' => $type,'message'=>$message]);
    }

    public function calculateProfit()
    {
        $items=session()->get('pos');
        $profit= new CalculateProfitService($items);
        $profit->gettingProfit();
    }

    public function createRunningStockBalance(){
	    $posItems=session()->get('pos');
	    foreach ($posItems as $key=>$item){
	        $originalAttrQty=ProductsAttribute::where('branch_id',auth()->user()->branch_id)->where('size_id',$item['size_id'])->first()->stock;
	        $runningStock=new SaleRunningStockService($item['size_id'],$item['quantity'],$originalAttrQty);
	        $runningStock->createRunningStock();
        }
    }

    public function findIfHasSession(){
        if(session()->get('pos')){
            return true;
        }else{
            return false;
        }
    }

    public function MpesaConfirm(){
        DB::transaction(function()
        {
            (new MpesaService($this->totalBill,$this->phone_number))->customerMpesaSTKPush();
        });
    }

    public function CardPayments(){
        DB::transaction(function()
        {
            $RequestingDeviceIP=$_SERVER['REMOTE_ADDR'];

            $client=new Client();
            $request=$client->post('http://'.$RequestingDeviceIP.'/api/KCBEFT',[
                    \GuzzleHttp\RequestOptions::JSON=>[
                        'TransactionAmount'=>$this->totalBill,
                    ]
                ]);
            $response=json_decode($request->getBody()->getContents());
            if($response->respCode!=="00"){
                $this->responseCode=$response->respCode;
                $this->responseMsg=$response->msg;
                $this->ifCardPaySuccess="FAILED";
            }else{
                $this->paymentMode="pinpad";
                $this->placeSaleForAllPaymentModes();
                $this->createRunningStockBalance();
                $sale_id = Sale::where('user_id',Auth::user()->id)
                    ->latest('id')->first()->id;
                (new CardPaymentService($response,$sale_id))->StoreCardPaymentDetails();
                if(auth()->user()->print_receipt===User::YES_PRINT_YES_DRAWER || auth()->user()->print_receipt===User::YES_PRINT_NO_DRAWER) {
                    if($this->TestIPPrinterConnection()==false){
                        $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
                        shell_exec('rundll32 user32.dll,MessageBeep');
                        $this->totalBill=0;
                    }else{
                        (new Mike42CustomerReceiptService($this->cashPay, $this->totalBill, $this->paymentMode,$response))->PrintIfEnabled();
                    }

                }else{
                    if(auth()->user()->print_receipt===User::NO_PRINT_YES_DRAWER){
                        if($this->TestIPPrinterConnection()==false) {
                            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
                            shell_exec('rundll32 user32.dll,MessageBeep');
                        }else{
                            $connector = new NetworkPrintConnector(auth()->user()->printer_ip, auth()->user()->printer_port);
                            $printer = new Printer($connector);
                            $printer->pulse();
                        }
                    }
                    $this->clearInputs();
                    return false;
                }
                $this->clearInputs();
            }
        });

    }


    public function render()
    {
        $this->undeclared=(new CashierUndeclaredCashService())->CalculateUndeclaredCash();
        $branch_id=Auth::user()->branch_id;
        $date_from=date('Y-m-d');
        $date_to=date('Y-m-d');

        $from    = \Illuminate\Support\Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $sales=Sale::with('branch')
            ->with('user')
            ->with('cashPayment')
            ->where('branch_id',$branch_id)
            ->where('user_id',Auth::user()->id)
            ->where('reversed',0)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        $total=Sale::with('branch')
            ->with('user')
            ->where('branch_id',$branch_id)
            ->where('user_id',Auth::user()->id)
            ->where('reversed',0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');
        $stocks=ProductsAttribute::with('branch')
            ->with('product')
            ->where('branch_id',Auth::user()->branch_id)
            ->paginate($this->perpage);

        $cashTotal=0;
        $cashSales=CashPayment::whereBetween('created_at', [$from, $to])
            ->where('reversed',CashPayment::IS_NOT_REVERSED)
            ->where('user_id',Auth::user()->id)
            ->get();

        foreach ($cashSales as $key => $cashsale) {
            $originalSale=$cashsale->sale?$cashsale->sale->reversed:'';
            if($originalSale==0) {
                $cashsale->sale?$cashTotal+=$cashsale->tendered-$cashsale->change:'';
            }
        }

        $pendingDeclarations=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_PENDING)
            ->orderBy('id', 'DESC')
            ->get();
        $pendingDeclarationsSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_PENDING)
            ->sum('amount');
        $declinedDeclarations=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_REJECTED)
            ->orderBy('id', 'DESC')
            ->get();
        $declinedDeclarationsSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_REJECTED)
            ->sum('amount');
        $approvedDeclarations=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_APPROVED)
            ->orderBy('id', 'DESC')
            ->get();
        $approvedDeclarationsSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_APPROVED)
            ->where('float',0)
            ->sum('amount');
        $totalCashSales=CashPayment::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('reversed',CashPayment::IS_NOT_REVERSED)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');
        $totalCardSales=CardPayment::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->where('reversed',CardPayment::IS_NOT_REVERSED)
            ->whereBetween('created_at', [$from, $to])
            ->sum('TransactionAmount');
        $userStatus=Auth::user()->status;
        $this->hasSession=$this->findIfHasSession();
        return view('livewire.pos-payments-section-component',compact(['sales','total','stocks','cashTotal','pendingDeclarations','declinedDeclarations','approvedDeclarations','pendingDeclarationsSum','declinedDeclarationsSum','approvedDeclarationsSum','totalCashSales','userStatus','totalCardSales']));
    }


}

