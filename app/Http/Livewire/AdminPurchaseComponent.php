<?php

namespace App\Http\Livewire;

use App\Services\CreateOrUpdateAttributesService;
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
class AdminPurchaseComponent extends Component
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

	public $branches;
	public $categories;
	public $products;
	public $sizes;
	public $suppliers;
	public $highCostError=false;
	public $canCompleteInvoice;



	public function mount(){
		$this->branches=Branch::all();
		$this->categories=Category::where('status',1)->get();
		$this->suppliers=Supplier::where('status',1)->get();
		$this->products=[];
		$this->sizes=[];
        $this->highCostError=false;
        $this->CheckAndUpdateIfCanCompleteStatus();

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
    public function updatedCategoryId(){
	    $this->products=[];
	    $this->sizes=[];
	    $this->cost='';
	    $this->rrp='';
	    $this->stock='';
	    $this->products=Product::where('category_id',$this->category_id)->get();
    }
    public function updatedProductId(){
        $this->sizes=[];
        $this->cost='';
        $this->rrp='';
        $this->stock='';
        $this->sizes=Size::where('product_id',$this->product_id)->get();
    }
    public function updatedSizeId(){
        $this->cost='';
        $this->rrp=ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->first()==null?'':ProductsAttribute::where('branch_id',$this->branch_id)->where('size_id',$this->size_id)->first()->price;
        $this->stock='';
    }
    public function AddProductToInvoice(){
        $validatedData = $this->validate([
            'branch_id'=>'required',
            'category_id'=>'required',
            'product_id'=>'required',
            'size_id'=>'required',
            'supplier_id'=>'required',
            'cost'=>'required|integer',
            'rrp'=>'required|integer',
            'stock'=>'required|integer',
        ]);

        if ($this->cost>$this->rrp) {
            $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Cost Price Higher than Retail Price','type'=>'warning']);
        } else {
            $this->createAddProductPurchase();
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
                                'cost'=>$this->cost,
                                'rrp'=>$this->rrp,
                                'stock'=>$this->stock,
                    ]
                ];
                session()->put('purchase_session',$purchase_session);
                $this->canCompleteInvoice=true;
                $this->ClearInputs();
            }


            // ===================================================================================
            // if pos not empty then check if this product exist then increment quantity


            elseif (isset($purchase_session[$this->size_id])) {
                $purchase_session[$this->size_id]['stock']=$purchase_session[$this->size_id]['stock']+$this->stock;
                session()->put('purchase_session',$purchase_session);
                $this->canCompleteInvoice=true;
                $this->ClearInputs();
            }
            // ==============================================================================
            // if item not exist in pos then add to pos with quantity but pos already exists
            else{
                //Check if same branch or supplier to create invoice
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
                    $this->dispatchBrowserEvent('showErrorEvent',['message'=>'Supplier and Branch Must be Same for Invoice']);
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
                        'cost'=>$this->cost,
                        'rrp'=>$this->rrp,
                        'stock'=>$this->stock,
                    ];
                    session()->put('purchase_session',$purchase_session);
                    $this->canCompleteInvoice=true;
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
    }
    private function CheckAndUpdateIfCanCompleteStatus()
    {
        if(session()->get('purchase_session')){
            $this->canCompleteInvoice=count(session()->get('purchase_session'))==0?false:true;
        }else{
            $this->canCompleteInvoice=false;
        }

    }

    public function CancelInvoiceCreation(){
	    session()->forget('purchase_session');
        $this->branch_id="";
        $this->supplier_id="";
        $this->branch_name="";
        $this->supplier_name="";
    }

    public function CompleteCreateInvoice(){
        (new OrderCreateService())->StorePurchaseItems();
        (new CreateOrUpdateAttributesService())->StoreAttributesParams();
        session()->forget('purchase_session');
        $this->branch_id="";
        $this->supplier_id="";
        $this->branch_name="";
        $this->supplier_name="";
        $this->canCompleteInvoice=false;
        $this->dispatchBrowserEvent('successCreatingInvoiceEvent',['message'=>'New Invoice Created Successfully!','type'=>'success']);

    }

    public function render()
    {
        $purchases=Purchase::paginate($this->perPage);
        return view('livewire.admin-purchase-component',['purchases'=>$purchases])->layout('layouts.admin');
    }


}
