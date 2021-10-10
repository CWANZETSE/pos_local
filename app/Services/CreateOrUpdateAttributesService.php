<?php


namespace App\Services;


use App\Models\Order;
use App\Models\ProductsAttribute;
use App\Models\Purchase;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateAttributesService
{
    public function StoreAttributesParams($orderId){
        $order=Order::find($orderId);
        $order_data=unserialize($order->order_data);

        $session=$order_data;
        $invoice_id=mt_rand(1000000000,9999999999);
        foreach($session as $key=>$params){
            $attr_count=DB::table('products_attributes')->count();
            if ($attr_count==0) {
                $attr=new ProductsAttribute;
                $attr->branch_id=$params['branch_id'];
                $attr->product_id=$params['product_id'];
                $attr->sku=Size::where('id',$key)->first()->sku;
                $attr->price=$params['rrp'];
                $attr->size=$params['size_name'];
                $attr->size_id=$key;//$key is the size_id
                $attr->stock=$params['stock'];
                $attr->save();

                (new PurchaseRunningStockService($key,$params['stock'],$params['branch_id'],$params['cost']))->createRunningStock();

            } else {
                $attr=ProductsAttribute::where('branch_id',$params['branch_id'])
                    ->where('product_id',$params['product_id'])
                    ->where('size_id',$key)
                    ->first();
                if ($attr==null) {
                    $attribute=new ProductsAttribute;
                    $attribute->branch_id=$params['branch_id'];
                    $attribute->product_id=$params['product_id'];
                    $attribute->sku=Size::where('id',$key)->first()->sku;
                    $attribute->price=$params['rrp'];
                    $attribute->size=$params['size_name'];
                    $attribute->size_id=$key;
                    $attribute->stock=$params['stock'];
                    $attribute->save();
                } else {
                    $attr->update(
                        [
                            'price'=>$params['rrp'],
                            'stock'=>$attr->stock+$params['stock'],
                        ]
                    );
                }


                (new PurchaseRunningStockService($key,$params['stock'],$params['branch_id'],$params['cost']))->createRunningStock();
            }
        }
    }
}
