<?php


namespace App\Services;
use App\Models\CardPayment;
use App\Models\GeneralSetting;
use App\Models\Sale;
use App\Models\User;
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

class Mike42CardReceiptReprintService
{
    private $halfLength=24;
    private $fullLength=48;
    private $Payload;
    private $sale_id;

    public function __construct($Payload,$sale_id)
    {
        $this->Payload=$Payload;
        $this->sale_id=$sale_id;

    }

    public function PrintIfEnabled(){


        $this->printPOSReceipt();


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
        $connector = new NetworkPrintConnector(auth()->user()->printer_ip,auth()->user()->printer_port);
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
            "postal"=>$setting ? $setting->store_address : null,
            "telephone"=>$setting ? $setting->store_phone: null,
            "email"=>$setting ? $setting->store_email: null,
        ];
        $sale = Sale::find($this->sale_id);

        $extra_headers=[
            "Sale #:"=>$sale->txn_code,
            "Store:"=>Auth::user()->branch->name,
            'DateTime:'=>Sale::find($this->sale_id)->created_at,
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

        $cartItems=$this->Payload;

        foreach(unserialize($cartItems) as $key=> $cartItem){
            $itemname=str_pad (Str::limit($cartItem['product_name'],24,$end='...')." ".$cartItem['size'], $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($itemname);
            $itemdiscountbreakdown=str_pad (number_format($cartItem['price']+$cartItem['discount'],2)." x ".$cartItem['quantity'], $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($cartItem['discount']>0?$itemdiscountbreakdown:'');
            $itembreakdown=str_pad (number_format($cartItem['price'],2)." x ".$cartItem['quantity'], $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($itembreakdown);
            $itemtotalprice=str_pad (number_format($cartItem['price']*$cartItem['quantity'],2), $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($itemtotalprice);
        }

        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

//            RECEIPT TOTALS HERE
        $total=0;
        foreach(unserialize($cartItems) as $key=> $cartItem){
            $total+=$cartItem['price']*$cartItem['quantity'];
        }
        $taxAmount=Sale::find($this->sale_id)->tax;
        $total_vars=[
            "Subtotal"=>$total-$taxAmount,
            "Discount"=>$sale->total_discount,
            "VAT Taxable ($sale->tax_rate %)"=>$sale->tax,
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


        $cardPayment=CardPayment::where('sale_id',$this->sale_id)->first();
        $pinpadPaid=[
            "AUTH CODE"=>$cardPayment->authCode,
            "RRN"=>$cardPayment->rrn,
            "PAN"=>$cardPayment->pan,
            "TID"=>$cardPayment->tid
        ];
        foreach($pinpadPaid as $key=> $value){
            $totalkey=str_pad ($key, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad ($value, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }





        $break=str_pad ("-", $this->fullLength, $pad_string = "-", $pad_type = STR_PAD_LEFT);
        $printer -> text($break);

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $totalInWords=str_pad($numberTransformer->toWords($sale->total)." KENYA SHILLINGS ONLY",$this->fullLength,$pad_string=" ", $pad_type=STR_PAD_RIGHT);
        $printer -> text(substr(strtoupper($totalInWords),0,40));
        $printer -> text(substr(strtoupper($totalInWords),40));

        $printer -> feed(2);


//            RECEIPT FOOTER HERE
        $endreceipt=str_pad ("**END OF LEGAL RECEIPT**", $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($endreceipt);
        $printer -> feed(2);
        $cashierReceipt=str_pad ("REPRINTED COPY", $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($cashierReceipt);
        $footer_vars=[
            "note"=>"Thank you for Shopping",
            "trading_hours"=>$setting ? $setting->store_footer_copyright : null,
            "servedBy"=>"You were served by: ".\App\Models\User::find($sale->user_id)->name,
            "testing"=>date('Y-m-d H:i:s'),
        ];
        foreach($footer_vars as $key =>$value){
            $printer -> text(str_pad ($value, $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH));
        }


        if(auth()->user()->print_receipt===User::YES_PRINT_NO_DRAWER){
            $printer -> cut();
            $printer -> close();
        }else{
            $printer -> pulse(); //CASH DRAWER OPEN
            $printer -> cut();
            $printer -> close();
        }


    }

}






