<?php


namespace App\Services;


use App\Models\CardPayment;

class CardPaymentService
{
    private $response;
    private $sale_id;

    public function __construct($response, $sale_id)
    {
        $this->response = $response;
        $this->sale_id = $sale_id;
    }

    public function StoreCardPaymentDetails(){
        CardPayment::create([
            "ResultCode"=>$this->response->ResultCode,
            "TransactionAmount"=>$this->response->TransactionAmount,
            "CashBackAmt"=>$this->response->CashBackAmt,
            "authCode"=>$this->response->authCode,
            "msg"=>$this->response->msg,
            "rrn"=>$this->response->rrn,
            "respCode"=>$this->response->respCode,
            "cardExpiry"=>$this->response->cardExpiry,
            "currency"=>$this->response->currency,
            "pan"=>$this->response->pan,
            "tid"=>$this->response->tid,
            "transType"=>$this->response->transType,
            "payDetails"=>$this->response->payDetails,
            "user_id"=>auth()->user()->id,
            "branch_id"=>auth()->user()->branch_id,
            "sale_id"=>$this->sale_id,
        ]);
    }

}
