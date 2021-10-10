<?php

namespace App\Http\Livewire;

use App\Services\PriceAndDiscountService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\ProductsAttribute;
use App\Models\Product;
class PosProductsSectionComponent extends Component
{

	public $attributeId;
	public $product_id;
	public $price;
	public $quantity;
	public $attributeIdKey;
	public $attribute_id;




	protected $listeners = [

        'AddToOrderEvent'=>'AddToOrder',
		'DeleteSessionFromProductsSectionEvent'=>'DeleteSessionFromProductsSection',
        'HoldBillEvent'=>'HoldBill',
        'ReleaseBillEvent'=>'ReleaseBill',
	];

//  =============================HOLD ACTIVE BILL================================================

    public function HoldBill(){
        $pos=session()->get('pos');
        $suspended_session=session()->get('suspended_session');
        if (!$suspended_session) {
            if ($pos) {
            $this->HoldActiveBill();
            $totalBill=0;
            $this->emit('totalAmountEvent',$totalBill);
                $this->dispatchBrowserEvent('BillHeldEvent');
            }else{
                $this->dispatchBrowserEvent('NoActiveBillToHoldErrorEvent');
                shell_exec('rundll32 user32.dll,MessageBeep');
            }
        } else {
            $this->dispatchBrowserEvent('BillAlreadySuspendedErrorEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
        }


    }

    public function HoldActiveBill(){
        $pos=session()->get('pos');
        session()->put('suspended_session',$pos);
        session()->forget('pos');
    }

//  ==================================RELEASE HELD BILL============================================

    public function ReleaseBill(){
        $suspended_session=session()->get('suspended_session');
        if ($suspended_session) {
            $this->ReleaseHeldBill();
            $this->dispatchBrowserEvent('ReleaseSuspendedBillEvent');
        }else{
            $this->dispatchBrowserEvent('NoBillInSessionErrorEvent');
            shell_exec('rundll32 user32.dll,MessageBeep');
        }
    }

    public function ReleaseHeldBill(){
        $suspended_session=session()->get('suspended_session');
        session()->put('pos',$suspended_session);
        $this->emit('TotalBillForSuspendedOrderEvent');
        session()->forget('suspended_session');
    }

// =================================ADD TO ORDER=======================================================

	public function AddToOrder($payload){
		$this->attributeIdKey=$payload;
		$this->AttributeAddToPosOrder();
	}


	public function AttributeAddToPosOrder()
    {
        $attribute=ProductsAttribute::find($this->attributeIdKey);
        $productPrice=(new PriceAndDiscountService(Auth::user()->branch_id,$attribute->size_id,$attribute->price))->getPriceAndDiscount();
        $productDiscount=(new PriceAndDiscountService(Auth::user()->branch_id,$attribute->size_id,$attribute->price))->getProductDiscount();

        $product=Product::where('id',$attribute->product_id)->first();


        $quantity=1;

        $pos=session()->get('pos');

        $suspended_session=session()->get('suspended_session');



        // GET QTY FROM SESSION BEFORE SEARCH
        $itemQty=0;

        if ($pos) {
                foreach ($pos as $key => $session) {

                if ($attribute->id==$key) {
                    $itemQty=$session['quantity'];
                }

            }
        }elseif ($suspended_session) {
            foreach ($suspended_session as $key => $session) {

                if ($attribute->id==$key) {
                    $itemQty=$session['quantity'];
                }

            }
        }
        else{
            $itemQty=0;
        }

        // END GET QTY FROM SESSION BEFORE SEARCH

        if ($attribute->stock<=$itemQty) {
            $this->MessageAlertEvent('error','Product Not Added!');
            shell_exec('rundll32 user32.dll,MessageBeep');
        }else{
             if (!$pos) {
                $pos = [
                       $this->attributeIdKey=>[
                            'sku'=>$attribute->sku,
                            'product_name'=>$product->name,
                            'size'=>$attribute->size,
                            'price'=>$productPrice,
                            'quantity'=>$quantity,
                            'size_id'=>$attribute->size_id,
                            'discount'=>$productDiscount,
                        ]
                ];
                session()->put('pos',$pos);
                $this->MessageAlertEvent('success','Product Added');
            }


    // ===================================================================================
    // if pos not empty then check if this product exist then increment quantity


            elseif (isset($pos[$this->attributeIdKey])) {
                    $pos[$this->attributeIdKey]['quantity']=$pos[$this->attributeIdKey]['quantity']+1;
                    session()->put('pos',$pos);
                    $this->MessageAlertEvent('success','Product Quantity Incremented');
            }
    // ==============================================================================
    // if item not exist in pos then add to pos with quantity but pos already exists
        else{
                $pos[$this->attributeIdKey]
                        =[
                            'sku'=>$attribute->sku,
                            'product_name'=>$product->name,
                            'size'=>$attribute->size,
                            'price'=>$productPrice,
                            'quantity'=>$quantity,
                            'size_id'=>$attribute->size_id,
                            'discount'=>$productDiscount,
                        ];

                session()->put('pos',$pos);
                $this->MessageAlertEvent('success','Product Added');
           }

           $this->updateTotalBillToPaymentsSection();
// ==================================================================================
    }


    }


// =============================REMOVE ITEM FROM POS=============================================

    public function ConfirmRemoveItemFromPOSModal($attrId){
        $this->attribute_id=$attrId;
        $this->dispatchBrowserEvent('ConfirmRemoveItemFromPOSModalEvent');

    }

    public function removeItemFromPos(){
            $pos=session()->get('pos');
            if (isset($pos[$this->attribute_id])) {
                unset($pos[$this->attribute_id]);
                session()->put('pos',$pos);
            }
            $this->updateTotalBillToPaymentsSection();
        $this->dispatchBrowserEvent('CloseRemoveItemFromPOSModalEvent');
    }



// =============================UPDATE TOTAL BILL PAYMENTS SECTION================================
    public function updateTotalBillToPaymentsSection(){
    	$totalAmount=0;
    	$pos=session()->get('pos');
        foreach($pos as $id=>$productAttribute){
            $totalAmount += $productAttribute['price']*$productAttribute['quantity'];
        }
         $this->emit('totalAmountEvent', $totalAmount);
    }



// =============================DELETE SESSION FROM PRODUCTS SECTION==============================
    public function DeleteSessionFromProductsSection(){

        session()->forget('pos');
    }

// =============================INSUFFICIENT STOCK ALERT=========================================
    public function InsufficientStockAlert(){
    	$this->MessageAlertEvent('error','Stock Insufficient!');
        shell_exec('rundll32 user32.dll,MessageBeep');
    }
// =============================MESSAGE ALERT EVENT=============================================
    public function MessageAlertEvent($type,$message){
    	 $this->dispatchBrowserEvent('MessageAlertEvent', ['type' => $type,'message'=>$message]);
    }

    public function render()
    {

        return view('livewire.pos-products-section-component');
    }
}
