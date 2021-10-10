<?php


namespace App\Services;
use App\Models\GeneralSetting;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use NumberToWords\NumberToWords;

class CardPaymentPrintService
{
    private $halfLength=24;
    private $fullLength=48;
    private $response;


    public function __construct($response)
    {
        $this->response = $response;

    }

    public function PrintIfEnabled(){
        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
            $printer_name="Test";
        }else{
            $setting=$allSettings->first();
            if ($setting->print_receipt){
                $this->printPOSReceipt();
            }else{
                $printer_name=$setting->printer_name;
                $connector = new WindowsPrintConnector("Receipt");
                $printer = new Printer($connector);
                $printer -> pulse();
                $printer -> close();
            }
        }
    }


    public function printPOSReceipt(){
        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
            $printer_name="Test";
        }else{
            $setting=$allSettings->first();
            $receipt_name=$setting->printer_name;
        }
        $connector = new WindowsPrintConnector("Receipt");
        $printer = new Printer($connector);
        //         create the number to words "manager" class
        $numberToWords = new NumberToWords();

//      build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('en');

//            RECEIPT HEADER HERE
        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
        }else{
            $setting=$allSettings->first();
        }

        $store_name=$setting ? $setting->store_name : null;
        $header_vars=[
        	"store_name"=>$setting ? $setting->store_name : null,
            "postal"=>$setting ? $setting->store_address : null,
            "telephone"=>$setting ? $setting->store_phone: null,
            "email"=>$setting ? $setting->store_email: null,
        ];
        $sale = Sale::where('user_id',Auth::user()->id)
            ->latest('id')->first();
        $extra_headers=[
            "Sale #:"=>$sale->txn_code,
            "Store:"=>Auth::user()->branch->name,
            'DateTime:'=>Carbon::now(),
        ];

        $settingsCount=GeneralSetting::all()->count();
        if ($settingsCount==0) {
            $headerLogo='null';
        }else{
            $headerLogo=GeneralSetting::first()->logo;
        }
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> feed(2);
        $printer -> setEmphasis(true);
        foreach($header_vars as $key =>$value){
            $somedata=str_pad ($value, 48, $pad_string = " ", $pad_type = STR_PAD_BOTH);
            $printer -> text($somedata);
            $printer -> feed();
        }

        $printer -> feed(2);
        $legal=str_pad ("LEGAL RECEIPT", $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($legal);
        $printer -> feed(2);

        foreach($extra_headers as $key=> $value){
            $totalkey=str_pad ($key, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad ($value, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }
        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

//            RECEIPT ITEMS HERE

        $cartItems=session()->get('pos');
        foreach($cartItems as $key=> $cartItem){
            $itemname=str_pad (Str::limit($cartItem['product_name'],24,$end='...')." ".$cartItem['size'], $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($itemname);
            $itembreakdown=str_pad (number_format($cartItem['price'],2)." x ".$cartItem['quantity'], $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($itembreakdown);
            $itemtotalprice=str_pad (number_format($cartItem['price']*$cartItem['quantity'],2), $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($itemtotalprice);
        }

        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

//            RECEIPT TOTALS HERE
        $total=0;
        foreach($cartItems as $key=> $cartItem){
            $total+=$cartItem['price']*$cartItem['quantity'];
        }
        $taxAmount=Sale::where('user_id',auth()->user()->id)->latest()->first()->tax;
        $total_vars=[
            "Subtotal"=>$total-$taxAmount,
            "Discount"=>0.00,
            "VAT TAXABLE ($setting->tax_percentage %)"=>$taxAmount,
            "TOTAL"=>$total,
        ];
        foreach($total_vars as $key=> $value){
            $totalkey=str_pad ($key, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad (number_format($value,2), $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }

        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

//        CASH OR MPESA PAYMENT MODE

        $cashPaid=[
            "Transaction Amount Amount"=>number_format($this->response->TransactionAmount,2),
            "Authorization"=>$this->response->authCode,
            "RRN"=>$this->response->rrn,
            "Card"=>$this->response->pan,
        ];
        foreach($cashPaid as $key=> $value){
            $totalkey=str_pad ($key, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad ($value, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }
        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $totalInWords=str_pad($numberTransformer->toWords($this->response->TransactionAmount)." KENYA SHILLINGS ONLY",$this->fullLength,$pad_string=" ", $pad_type=STR_PAD_RIGHT);
        $printer -> text(substr(strtoupper($totalInWords),0,40));
        $printer -> text(substr(strtoupper($totalInWords),40));

        $printer -> feed(2);


//            RECEIPT FOOTER HERE
        $endreceipt=str_pad ("**END OF LEGAL RECEIPT**", $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($endreceipt);
        $printer -> feed(2);
        $cashierReceipt=str_pad ("CUSTOMER COPY", $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($cashierReceipt);
        $footer_vars=[
            "note"=>"Thank you for Shopping",
            "trading_hours"=>$setting ? $setting->store_footer_copyright : null,
            "servedBy"=>"You were served by: ".auth()->user()->name,
            "testing"=>date('Y-m-d H:i:s'),
        ];
        foreach($footer_vars as $key =>$value){
            $printer -> text(str_pad ($value, $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH));
        }


        $printer -> pulse();
        $printer -> cut();
        $printer -> close();
    }
}






