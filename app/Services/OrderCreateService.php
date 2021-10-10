<?php


namespace App\Services;


use App\Models\Branch;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Size;
use App\Models\Supplier;
use App\Models\SupplierHistory;
use Illuminate\Support\Carbon;

class OrderCreateService
{
    public function StoreOrderItems($branchId,$supplierId): void
    {
        $session_data=session()->get('purchase_session');

        $total=0;

        foreach($session_data as $data){
            $total+=$data['cost']*$data['stock'];
        }

        $order_id=mt_rand(1000000000,9999999999);
            Order::create([
                'order_id'=>$order_id,
                'branch_id'=>$branchId,
                'supplier_id'=>$supplierId,
                'order_data'=>serialize($session_data),
                'created_by'=>auth()->user()->id,
                'order_total'=>$total,
            ]);

    }

    public function StorePurchaseItems($orderId){

            $order=Order::find($orderId);
            $num_due_date=Supplier::find($order->supplier_id)->invoice_due_days;
            $order_data=$order->order_data;

            $invoice_id=mt_rand(1000000000,9999999999);

            $total=0;

            foreach(unserialize($order_data) as $data){
                $total+=($data['cost']*$data['stock']);
            }


            Purchase::create([
                'order_id'=>$order->order_id,
                'branch_id'=>$order->branch_id,
                'supplier_id'=>$order->supplier_id,
                'invoice_id'=>$invoice_id,
                'order_data'=>$order_data,
                'due_on'=>Carbon::now()->addDays($num_due_date),
            ]);

            $branch=Branch::find($order->branch_id)->name;
            $history=SupplierHistory::count();
            $supplier_code=Supplier::find($order->supplier_id)->supplier_code;
            if($history==0){
                $balance=0-$total;
            }else{
                $balance=SupplierHistory::where('supplier_code',$supplier_code)->latest()->first()?SupplierHistory::where('supplier_code',$supplier_code)->latest()->first()->balance-$total:0-$total;
            }
            SupplierHistory::create([
                'supplier_code'=>$supplier_code,
                'invoice_id'=>$invoice_id,
                'description'=>'Supply Order '.$order->order_id,
                'money_out'=>$total,
                'balance'=>$balance,
            ]);


    }

}
