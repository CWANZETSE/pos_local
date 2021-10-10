<?php


namespace App\Services;


use App\Models\CardPayment;
use App\Models\CashPayment;
use App\Models\Declarations;
use App\Models\GeneralSetting;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use NumberToWords\NumberToWords;

class PrintCashierTransactionSummaryService
{
    public function printTodaySummary(){

        $branch_id=Auth::user()->branch_id;
        $date_from=date('Y-m-d');
        $date_to=date('Y-m-d');
        $fullLength=48;
        $halfLength=24;

        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $totalSalesUsingAllModes=Sale::with('branch')
            ->with('user')
            ->where('branch_id',$branch_id)
            ->where('user_id',Auth::user()->id)
            ->where('reversed',0)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');

        $pendingDeclarationsSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_PENDING)
            ->sum('amount');
        $declinedDeclarationsSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_REJECTED)
            ->sum('amount');
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
        $pendingFloatSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch->id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_PENDING)
            ->where('float',1)
            ->sum('amount');
        $approvedFloatSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch->id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_APPROVED)
            ->where('float',1)
            ->sum('amount');
        $approvedExpensesSum=Declarations::where('user_id',Auth::user()->id)
            ->where('branch_id',Auth::user()->branch->id)
            ->whereBetween('created_at', [$from, $to])
            ->where('status',Declarations::IS_APPROVED)
            ->where('destination','expense')
            ->sum('amount');
        $undeclared=(new CashierUndeclaredCashService())->CalculateUndeclaredCash();

        $netCash=$approvedDeclarationsSum-$approvedExpensesSum;
        $expectedNetCash=$totalCashSales-$approvedExpensesSum;

        if ($totalCashSales==$approvedDeclarationsSum && $pendingFloatSum==0){
            $ifBalanced=true;
        }else{
            $ifBalanced=false;
        }


        //START PRINTING
        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
            $receipt_name="Test";
        }else{
            $setting=$allSettings->first();
            $receipt_name=$setting->printer_name;
        }
        $connector = new NetworkPrintConnector(auth()->user()->printer_ip,auth()->user()->printer_port);
        $printer = new Printer($connector);
        //         create the number to words "manager" class
        $numberToWords = new NumberToWords();

//      build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('en');

//            RECEIPT HEADER HERE

        $store_name=$setting ? $setting->store_name : null;
        $header_vars=[
            "postal"=>$setting ? $setting->store_address : null,
            "city"=>"Nairobi",
            "telephone"=>$setting ? $setting->store_phone: null,
            "email"=>$setting ? $setting->store_email: null,
        ];


        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $headerLogo='null';
        }else{
            $headerLogo=GeneralSetting::first()->logo;
        }
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $img = EscposImage::load(storage_path('app/public/logos/'.$headerLogo));
        $printer -> bitImage($img,Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);

        $printer -> selectPrintMode();
        $printer -> feed(2);
        $printer -> setEmphasis(true);
        foreach($header_vars as $key =>$value){
            $somedata=str_pad ($value, 48, $pad_string = " ", $pad_type = STR_PAD_BOTH);
            $printer -> text($somedata);
            $printer -> feed();
        }

        $declaration=Declarations::find(40);

        $printer -> feed(2);
        $legal=str_pad ("CASHIER EOD SUMMARY", $fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($legal);
        $printer -> feed(2);


        $extra_headers=[
            "Store Name:"=>Auth::user()->branch->name,
            'Cashier Name:'=>Auth::user()->name,
            'Transaction Date:'=>date('l jS F Y'),
            'Cash Sales:'=>number_format($totalCashSales,2),
            'Card Sales:'=>number_format($totalCardSales,2),
            'Total Sales:'=>number_format($totalSalesUsingAllModes,2),
            'Pending Cash:'=>number_format($pendingDeclarationsSum,2),
            'Approved Cash:'=>number_format($approvedDeclarationsSum,2),
            'Pending Float:'=>number_format($pendingFloatSum,2),
            'Approved Expense:'=>number_format($approvedExpensesSum,2),
            'Undeclared Cash:'=>number_format($undeclared,2),
        ];
        foreach($extra_headers as $key=> $value){
            $totalkey=str_pad ($key, $halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad ($value, $halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }

        $printer -> feed(2);

        $totalkey=str_pad ("TILL BALANCE", $halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
        $printer -> text($totalkey);
        $totalvalue=str_pad ($ifBalanced?'PASS':'FAIL', $halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
        $printer -> text($totalvalue);

        $printer -> feed(2);
        $printer->text("Printed: ". \Carbon\Carbon::now());
        $printer -> feed(2);
        $printer->text('THANK YOU');
        $printer->text('THANK YOU');

        $printer -> cut();
        $printer -> close();
    }
}
