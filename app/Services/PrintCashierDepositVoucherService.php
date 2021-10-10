<?php


namespace App\Services;


use App\Models\GeneralSetting;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use NumberToWords\NumberToWords;
use App\Models\Declarations;

class PrintCashierDepositVoucherService
{
    private $declarationId;
    private $halfLength=24;
    private $fullLength=48;

    public function __construct($declarationId)
    {
        $this->declarationId = $declarationId;

    }


    public function printDepositVoucher(){
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
        $printer -> feed(2);
        $printer -> setEmphasis(true);
        foreach($header_vars as $key =>$value){
            $somedata=str_pad ($value, 48, $pad_string = " ", $pad_type = STR_PAD_BOTH);
            $printer -> text($somedata);
            $printer -> feed();
        }

        $declaration=Declarations::find($this->declarationId);

        $printer -> feed(2);
        $legal=str_pad ($declaration->float? 'FLOAT DECLARATION VOUCHER':'CASH DECLARATION VOUCHER', $this->fullLength, $pad_string = " ", $pad_type = STR_PAD_BOTH);
        $printer -> text($legal);
        $printer -> feed(2);


        $extra_headers=[
            "STORE:"=>strtoupper($declaration->branch->name),
            "AMOUNT:"=>"Ksh ".number_format($declaration->amount,2),
            'REFERENCE:'=>$declaration->reference,
            'CASHIER:'=>strtoupper($declaration->user->name),
            'DESTINATION:'=>strtoupper($declaration->destination),
            'CURRENT STATUS:'=>$declaration->status==1?strtoupper('confirmed'):'',
            'FLOAT:'=>$declaration->float? 'YES':'NO',
            'SUBMITTED DATETIME:'=>$declaration->created_at,
            'CONFIRMED DATETIME:'=>$declaration->updated_at,
            'CONFIRMING OFFICIAL:'=>$declaration->admin_id? strtoupper($declaration->admin->name):'',
            'APPROVAL COMMENTS:'=>strtoupper($declaration->comments),
        ];
        foreach($extra_headers as $key=> $value){
            $totalkey=str_pad ($key, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_RIGHT);
            $printer -> text($totalkey);
            $totalvalue=str_pad ($value, $this->halfLength, $pad_string = " ", $pad_type = STR_PAD_LEFT);
            $printer -> text($totalvalue);
        }

        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $totalInWords=str_pad($numberTransformer->toWords($declaration->amount)." KENYA SHILLINGS ONLY",$this->fullLength,$pad_string=" ", $pad_type=STR_PAD_RIGHT);
        $printer -> text(substr(strtoupper($totalInWords),0,40));
        $printer -> text(substr(strtoupper($totalInWords),40));
        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Voucher Printed: ".Carbon::now());
        $printer -> feed(2);
        $printer->text('THANK YOU');
        $printer->text('THANK YOU');


        $printer -> cut();
        $printer -> close();
    }
}
