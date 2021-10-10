<?php

namespace App\Http\Livewire;

use App\Models\CardPayment;
use App\Models\Declarations;
use App\Models\Shift;
use App\Models\User;
use App\Services\LogsService;
use App\Services\CashierUndeclaredCashService;
use App\Services\Mike42CardReceiptReprintService;
use App\Services\Mike42CashReceiptReprintService;
use App\Services\Mike42CustomerReceiptService;
use App\Services\PrintCashierDepositVoucherService;
use App\Services\PrintCashierTransactionSummaryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\Sale;
use App\Models\ProductsAttribute;
use App\Models\CashPayment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
class PosTopBarComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $perpage=10;
	public $oldPassword;
	public $newPassword;
	public $repeatNewPassword;
	public $state=[];
	public $successMsg=false;
	public $zeroErrorMsg=false;
	public $maximumErrorMsg=false;
	public $undeclared;
	public $numOfHeldProducts=0;
	public $confirmPassword;
	public $shift_closed;
	public $sales_allowed_reprint=[];
	public $hold_release_bill;


	protected $rules = [
        'oldPassword' => 'required',
        'newPassword' => 'required|min:6',
        'repeatNewPassword' => 'required|min:6',
    ];

	protected $listeners=[
	    'HeldProductsEvent'=>'CalculateHeldProducts'
    ];



	public function mount(){
        $user=User::find(Auth::user()->id);
        $this->shift_closed=$user->assigned_till==0?'true':'false';

    }



	public function TestIPPrinterConnection(){
        $fp = @fsockopen(auth()->user()->printer_ip,auth()->user()->printer_port, $errno, $errstr, 2);
        if ($fp === false) {
            return false;
        }else{
            return true;
        }
    }

    public function OpenCashDrawerModal(){
        $this->dispatchBrowserEvent('viewOpenCashDrawerModal');
    }
    public function ReprintReceiptModal(){
        $this->dispatchBrowserEvent('ReprintReceiptModalEvent');
        $this->sales_allowed_reprint=Sale::where('user_id',Auth::user()->id)->where('allow_reprint',1)->get();
    }
    public function OpenCashDrawer(){
        if($this->TestIPPrinterConnection()===false){
            shell_exec('rundll32 user32.dll,MessageBeep');
            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
        }else{
            $connector = new WindowsPrintConnector("Receipt");
            $printer = new Printer($connector);
            $printer -> pulse();
            $printer -> close();
        }

    }
    public function viewChangePasswordModal(){
		$this->dispatchBrowserEvent('viewChangePasswordModalEvent');
	}
    public function confirmPasswordForTill(){
        $hashedPassword = Auth::user()->password;

        if(Hash::check($this->confirmPassword, $hashedPassword)) {
            $this->dispatchBrowserEvent('hideCashDrawerModal');
            $this->OpenCashDrawer();
            $this->confirmPassword="";

        }else{
            $this->confirmPassword="";
            $this->dispatchBrowserEvent('errorOpeningCashDrawerEvent',['message'=>"There was an error",'type'=>'error']);
            $this->dispatchBrowserEvent('hideCashDrawerModal');
        }
    }
    public function ReprintReceipt($sale_id){
        if($this->TestIPPrinterConnection()===false){
            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
            $this->totalBill=0;
        }else{
            $sale=Sale::find($sale_id);
            $cash_payments_ids=[];
            $cash_payments=CashPayment::all();
            foreach($cash_payments as $cash_payment){
                $cash_payments_ids[] = $cash_payment->sale_id;
            }
            if(in_array($sale_id,$cash_payments_ids)){
                $payment=CashPayment::where('sale_id',$sale_id)->first();
                $cashPay=$payment->tendered;
                $totalBill=$payment->total;
                $paymentMode="cash";
                $Payload=$sale->sale;
                $sale_id=$sale_id;
                (new Mike42CashReceiptReprintService($cashPay, $totalBill, $Payload,$sale_id))->PrintIfEnabled();
                $sale->update([
                    'allow_reprint'=>0,
                ]);
                (new LogsService('reprinted sale rct '.$sale->txn_code,'User'))->storeLogs();
                $this->dispatchBrowserEvent('CloseReprintReceiptModalEvent');
                $this->dispatchBrowserEvent('SuccessReprintingReceiptModalEvent');

            }else{
                $Payload=$sale->sale;
                (new Mike42CardReceiptReprintService($Payload,$sale_id))->PrintIfEnabled();
                $sale->update([
                    'allow_reprint'=>0,
                ]);
                (new LogsService('reprinted sale rct '.$sale->txn_code,'User'))->storeLogs();
                $this->dispatchBrowserEvent('CloseReprintReceiptModalEvent');
                $this->dispatchBrowserEvent('SuccessReprintingReceiptModalEvent');
            }


//            (new Mike42CustomerReceiptService($this->cashPay, $this->totalBill, $this->paymentMode,$response))->PrintIfEnabled();
        }
    }

    public function CancelReprintReceipt($sale_id){
        $sale=Sale::find($sale_id);
        $sale->update([
            'allow_reprint'=>0,
        ]);
        $this->dispatchBrowserEvent('CloseReprintReceiptModalEvent');
        $this->dispatchBrowserEvent('DismissReprintingReceiptModalEvent');
    }

    public function viewDepositsModal(){
        $this->state=[];
        $this->successMsg=false;
        $this->zeroErrorMsg=false;
        $this->maximumErrorMsg=false;
        $this->dispatchBrowserEvent('viewDepositsModalEvent');
    }
    public function printCashDepositVoucher($id){
        if($this->TestIPPrinterConnection()===false){
            shell_exec('rundll32 user32.dll,MessageBeep');
            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
        }else {
            (new PrintCashierDepositVoucherService($id))->printDepositVoucher();
        }
    }
    public function DeclareCash(){
        $this->successMsg=false;
        $this->test=7000;
        $validatedData=Validator::make($this->state,[
            'amount'=>'required',
            'destination'=>'required',
        ])->validate();
        $undeclaredCash=(new CashierUndeclaredCashService())->CalculateUndeclaredCash();
        if ($undeclaredCash<$this->state['amount']){
            $this->maximumErrorMsg=true;
            $this->zeroErrorMsg=false;
            $this->successMsg=false;
        }else if($this->state['amount']<=0){
            $this->zeroErrorMsg=true;
            $this->maximumErrorMsg=false;
            $this->successMsg=false;
        }
        else{
            Declarations::create([
                'user_id'=>Auth::user()->id,
                'branch_id'=>Auth::user()->branch_id,
                'txn_date'=> \Illuminate\Support\Carbon::now(),
                'amount'=>$this->state['amount'],
                'reference'=>mt_rand(1000000000000,9999999999999),
                'destination'=>$this->state['destination'],
                'status'=>Declarations::IS_PENDING,
                'details'=>'self',
            ]);
            (new LogsService('declared cash','User'))->storeLogs();
            $this->dispatchBrowserEvent('successDeclaringAmountEvent',['type'=>'success','message'=>'Declaration of Ksh '.number_format($this->state['amount'],2).' submitted for approval. Please wait']);
            $this->successMsg=true;
            $this->zeroErrorMsg=false;
            $this->maximumErrorMsg=false;
            $this->state=[];
        }

    }
    public function PrintCashierTransactionSummary(){
        if($this->TestIPPrinterConnection()===false){
            shell_exec('rundll32 user32.dll,MessageBeep');
            $this->dispatchBrowserEvent('ModalIPPrinterNotConnectedEvent');
        }else {
            (new PrintCashierTransactionSummaryService())->printTodaySummary();
        }
    }

    public function changePassword(){
		$this->validate();
        if (Hash::check($this->oldPassword, Auth::user()->password)) {
                if (strcmp( $this->newPassword, $this->repeatNewPassword )==0) {
                	$user=Auth::user();
                	$user->update(['password'=>bcrypt($this->newPassword)]);
                	$this->newPassword="";
                	$this->repeatNewPassword="";
                	$this->oldPassword="";
                	$this->dispatchBrowserEvent('closeChangePasswordModalEvent');
                	$this->dispatchBrowserEvent('showEventMessage',['message'=>'Password Changed Successfully!','type'=>'success','title'=>'Success!']);
                }else{
                	$this->dispatchBrowserEvent('showEventMessage',['message'=>'Passwords do not match!','type'=>'error','title'=>'Error!']);
                }
            }else{
                $this->dispatchBrowserEvent('showEventMessage',['message'=>'Old password is incorrect!','type'=>'error','title'=>'Error!']);
            }
    }

    public function updatePassword(Request $request){
        $admin=Admin::find(Auth::user()->id);
        $admin->update(['password'=>bcrypt($request['new_password'])]);
        return response()->json($admin);
    }

    public function resetPassword(Request $request){
        $admin=Admin::find($request['admin_id']);
        $new_password=mt_rand(111111,999999);
        $admin->update(['password'=>bcrypt($new_password)]);
        return response()->json($new_password);
    }



    public function render()
    {

            $this->undeclared=(new CashierUndeclaredCashService())->CalculateUndeclaredCash();
    		$branch_id=Auth::user()->branch_id;
	        $date_from=date('Y-m-d');
	        $date_to=date('Y-m-d');

	        $from    = Carbon::parse($date_from)
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

             // *********************************CASH SETTLEMENT*****************************
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
        return view('livewire.pos-top-bar-component',compact(['sales','total','stocks','cashTotal','pendingDeclarations','declinedDeclarations','approvedDeclarations','pendingDeclarationsSum','declinedDeclarationsSum','approvedDeclarationsSum','totalCashSales','userStatus','totalCardSales']));
    }
}
