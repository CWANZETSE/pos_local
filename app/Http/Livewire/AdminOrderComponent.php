<?php

namespace App\Http\Livewire;

use App\Services\CreateOrUpdateAttributesService;
use App\Services\LogsService;
use App\Services\OrderCreateService;
use App\Services\PurchaseRunningStockService;
use Livewire\Component;
use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use DB;
use App\Models\ProductsAttribute;
class AdminOrderComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage;


    public $branch_id;
    public $category_id;
    public $product_id;
    public $size_id;
    public $supplier_id;
    public $code;
    public $cost;
    public $rrp;
    public $stock;
    public $supplier_name;
    public $branch_name;

    public $category;
    public $product;
    public $size;

    public $branches;
    public $categories;
    public $products;
    public $sizes;
    public $suppliers;
    public $highCostError=false;
    public $canCompleteOrder;
    public $sku_code;
    public $packaging;
    public $cost_per_pack;
    public $qty_in_pack;
    public $no_of_packs;
    public $estimated_cost;
    public $priceAlreadySet;
    public $SuccessAddingProductToOrder=false;



    public function mount(){
        $this->branches=Branch::all();
        $this->categories=Category::where('status',1)->get();
        $this->suppliers=Supplier::where('status',1)->get();
        $this->products=[];
        $this->sizes=[];
        $this->packaging='single_units';
        $this->estimated_cost=0;
        $this->highCostError=false;
        $this->priceAlreadySet=false;
        $this->CheckAndUpdateIfCanCompleteStatus();
        $this->clearInputs();

    }

    public function updatedCostPerPack(){
        $this->estimated_cost=$this->qty_in_pack>0?$this->cost_per_pack/$this->qty_in_pack:0;
    }
    public function updatedQtyInPack(){
        $this->estimated_cost=$this->cost_per_pack>0?$this->cost_per_pack/$this->qty_in_pack:0;
    }
    public function updatedPackaging(){
        $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
            ->where('size_id',$this->size_id)
            ->latest()
            ->first();
        $size= Size::where('sku', $this->sku_code)->first() ?: null;
        $set_price=ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->first()==null?'':ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->first()->price;
        if($size!==null){
            $this->priceAlreadySet=$set_price>0?true:false;
            $this->rrp=$set_price>0?$set_price:'';
        }else{
            $this->clearInputs();
            $this->priceAlreadySet=$set_price>0?true:false;
        }
    }



    public function ShowSupplierSelectModal(){
        $this->dispatchBrowserEvent('ShowSupplierSelectModalEvent');
    }

    public function SelectSupplierFromModal(){
        $this->supplier_name=Supplier::find($this->supplier_id)->name;
        $this->dispatchBrowserEvent('HideSupplierSelectModalEvent');
    }
    public function ShowBranchSelectModal(){
        $this->dispatchBrowserEvent('ShowBranchSelectModalEvent');
    }

    public function SelectBranchFromModal(){
        $this->branch_name=Branch::find($this->branch_id)->name;
        $this->dispatchBrowserEvent('HideBranchSelectModalEvent');
    }

    public function updatedSkuCode(){
        $this->clearInputs();
        $this->SuccessAddingProductToOrder=false;
        if ($this->branch_id=="" || $this->supplier_id==""){
            $this->sku_code ="";
            $validatedData = $this->validate([
                'sku_code'=>'required',
            ]);
        }
        $size= Size::where('sku', $this->sku_code)->first() ?: null;
        $size_id=Size::where('sku',$this->sku_code)->first()?Size::where('sku',$this->sku_code)->first()->id:null;
        $this->size_id=$size_id;


        $size_name=Size::where('sku', $this->sku_code)->first()? Size::findOrFail($size_id)->name:"";
        $product_id=Size::where('sku', $this->sku_code)->first()? Size::findOrFail($size_id)->product_id:"";
        $product_name=Size::where('sku', $this->sku_code)->first()? Product::findOrFail($product_id)->name:"";
        $category_id=Size::where('sku', $this->sku_code)->first()?Product::findOrFail($product_id)->category_id:"";
        $category_name=Size::where('sku', $this->sku_code)->first()?Category::findOrFail($category_id)->name:"";

        $this->category_id=$category_id;
        $this->product_id=$product_id;
        $this->size_id=$size_id;

        $attrib=ProductsAttribute::where('branch_id',$this->branch_id)
            ->where('size_id',$size_id)
            ->latest()
            ->first();
        $set_price=ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$size_id)->first()==null?'':ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$size_id)->first()->price;
        if($size!==null){
            $this->category=$category_name;
            $this->product=$product_name;
            $this->size=$size_name;
            $this->priceAlreadySet=$set_price>0?true:false;
            $this->rrp=$set_price>0?$set_price:'';
        }else{
            $this->clearInputs();
            $this->priceAlreadySet=$set_price>0?true:false;
        }
    }


    public function AddProductToOrder(){
        $this->SuccessAddingProductToOrder=false;
        if($this->packaging==="single_units"){
            $validatedData = $this->validate([
                'branch_id'=>'required',
                'supplier_id'=>'required',
                'cost'=>'required|integer',
                'rrp'=>'required|integer',
                'sku_code'=>'required',
                'stock'=>'required|integer',
            ]);
        }else{
            $validatedData = $this->validate([
                'branch_id'=>'required',
                'supplier_id'=>'required',
                'cost_per_pack'=>'required|integer',
                'qty_in_pack'=>'required|integer',
                'no_of_packs'=>'required|integer',
                'rrp'=>'required|integer',
                'sku_code'=>'required',
            ]);
        }

        if ($this->CalculateCost()>$this->rrp) {
            $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Cost price higher than selling price','type'=>'error']);
            $this->rrp=0;
        } else {
            $this->createAddProductPurchase();
        }

    }
    private function CalculateStock(){
        if($this->packaging==="pack"){
            $stock=$this->qty_in_pack*$this->no_of_packs;
            return $stock;
        }else{
            return $this->stock;
        }
    }
    private function CalculateCost(){
        if($this->packaging==="pack"){
            $cost=($this->cost_per_pack/$this->qty_in_pack);
            return $cost;
        }else{
            return $this->cost;
        }
    }
    private function createAddProductPurchase()
    {
        $purchase_session=session()->get('purchase_session');
        if (!$purchase_session) {
            $purchase_session = [
                $this->size_id=>[
                    'supplier_id'=>$this->supplier_id,
                    'supplier_name'=>Supplier::find($this->supplier_id)->name,
                    'branch_id'=>$this->branch_id,
                    'category_id'=>Size::find($this->size_id)->product->category_id,
                    'product_id'=>Size::find($this->size_id)->product->id,
                    'branch_name'=>Branch::find($this->branch_id)->name,
                    'product_name'=>Size::find($this->size_id)->product->name,
                    'size_id'=>$this->size_id,
                    'size_name'=>Size::find($this->size_id)->name,
                    'cost'=>$this->CalculateCost(),
                    'rrp'=>$this->rrp,
                    'stock'=>$this->CalculateStock(),
                    'packaging'=>$this->packaging,
                    'qty_in_pack'=>$this->packaging==="pack"?$this->qty_in_pack:0,
                    'no_of_packs'=>$this->packaging==="pack"?$this->no_of_packs:0,
                    'cost_per_pack'=>$this->packaging==="pack"?$this->cost_per_pack:0,
                ]
            ];
            session()->put('purchase_session',$purchase_session);
            $this->canCompleteOrder=true;
            $this->SuccessAddingProductToOrder=true;
            $this->sku_code="";
            $this->ClearInputs();
        }


        // ===================================================================================
        // if pos not empty then check if this product exist then *increment quantity*-display error message


        elseif (isset($purchase_session[$this->size_id])) {
//            $purchase_session[$this->size_id]['stock']=$purchase_session[$this->size_id]['stock']+$this->CalculateStock();
//            session()->put('purchase_session',$purchase_session);
            $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Product already exists','type'=>'error']);

        }
        // ==============================================================================
        // if item not exist in pos then add to pos with quantity but pos already exists
        else{
            //Check if same branch or supplier to create order
            $purchase_session=session()->get('purchase_session');
            $all_branches_keys=[];
            $all_suppliers_keys=[];
            foreach ($purchase_session as $session){
                array_push($all_branches_keys,$session['branch_id']);//all branch ids
            }
            foreach ($purchase_session as $session){
                array_push($all_suppliers_keys,$session['supplier_id']);// all supplier ids
            }
            if($this->branch_id!==$all_branches_keys[0] || $this->supplier_id!==$all_suppliers_keys[0]){
                $this->SuccessAddingProductToOrder=false;
                $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Supplier and Branch must be same for Purchase Order','type'=>'error']);
            }else{
                $purchase_session[$this->size_id] = [
                    'supplier_id'=>$this->supplier_id,
                    'supplier_name'=>Supplier::find($this->supplier_id)->name,
                    'branch_id'=>$this->branch_id,
                    'branch_name'=>Branch::find($this->branch_id)->name,
                    'category_id'=>Size::find($this->size_id)->product->category_id,
                    'product_id'=>Size::find($this->size_id)->product->id,
                    'product_name'=>Size::find($this->size_id)->product->name,
                    'size_id'=>$this->size_id,
                    'size_name'=>Size::find($this->size_id)->name,
                    'cost'=>$this->CalculateCost(),
                    'rrp'=>$this->rrp,
                    'stock'=>$this->CalculateStock(),
                    'packaging'=>$this->packaging,
                    'qty_in_pack'=>$this->packaging==="pack"?$this->qty_in_pack:0,
                    'no_of_packs'=>$this->packaging==="pack"?$this->no_of_packs:0,
                    'cost_per_pack'=>$this->packaging==="pack"?$this->cost_per_pack:0,
                ];
                session()->put('purchase_session',$purchase_session);
                $this->canCompleteOrder=true;
                $this->SuccessAddingProductToOrder=true;
                $this->sku_code="";
                $this->ClearInputs();
            }

        }
    }
    public function RemoveProduct($sizeId){
        $purchase_session=session()->get('purchase_session');
        if (isset($purchase_session[$sizeId])) {
            unset($purchase_session[$sizeId]);
            session()->put('purchase_session',$purchase_session);
        }
        $this->CheckAndUpdateIfCanCompleteStatus();

    }

    public function ClearInputs(){
        $this->category_id="";
        $this->product_id="";
        $this->size_id="";
        $this->cost="";
        $this->rrp="";
        $this->stock="";
        $this->category_id="";
        $this->product_id="";
        $this->size_id="";
        $this->category="";
        $this->product="";
        $this->size="";
        $this->cost_per_pack="";
        $this->qty_in_pack="";
        $this->no_of_packs="";
        $this->packaging="single_units";
        $this->estimated_cost=0;
    }
    private function CheckAndUpdateIfCanCompleteStatus()
    {
        if(session()->get('purchase_session')){
            $this->canCompleteOrder=count(session()->get('purchase_session'))==0?false:true;
        }else{
            $this->canCompleteOrder=false;
        }

    }

    public function NewOrderModal(){
        $this->SuccessAddingProductToOrder=false;
        $this->dispatchBrowserEvent('AdminNewPurchaseOrderModalEvent');
    }

    public function CancelOrderCreation(){
        session()->forget('purchase_session');
        $this->branch_id="";
        $this->supplier_id="";
        $this->branch_name="";
        $this->supplier_name="";
    }

    public function CompleteCreateOrder(){
        if(session()->get('purchase_session')){
            $data=session()->get('purchase_session');
            foreach($data as $detail){
                $this->branch_id=$detail['branch_id'];
                $this->supplier_id=$detail['supplier_id'];
            }

        }
        (new OrderCreateService())->StoreOrderItems($this->branch_id,$this->supplier_id);
        session()->forget('purchase_session');
        $this->branch_id="";
        $this->supplier_id="";
        $this->branch_name="";
        $this->supplier_name="";
        $this->canCompleteOrder=false;
        (new LogsService('placed new order' ,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successCreatingInvoiceEvent',['message'=>'New Purchase Order Created Successfully!','type'=>'success']);

    }

    public function render()
    {
        $purchases=Purchase::paginate($this->perPage);
        return view('livewire.admin-order-component',['purchases'=>$purchases])->layout('layouts.admin');
    }


}
