<?php

namespace App\Http\Livewire;

use App\Models\GeneralSetting;
use App\Models\ProductsAttribute;
use App\Services\LogsService;
use Livewire\Component;
use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class AdminSizeComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $updatingMode=false;
	public $error=false;
	public $viewingMode=false;
	public $state=[];
	public $sizeId;
	public $sorting='default';
	public $pagesize=10;
	public $search='';
	public $category_id;
	public $taxable;
	public $tax_percentage;
	public $reorder_level;


	public function mount(){
		$this->state['status']=true;
		$this->productStatus=false;

	}
	public function showCreateSizeModal(){
		$this->state=[];
		$this->updatingMode=false;
		$this->viewingMode=false;
		$this->state['status']=true;
		$this->taxable=1;
		$this->dispatchBrowserEvent('showSizeModal');
	}
	public function AddSize(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required',
			'sku'=>'required|unique:sizes',
			'product_id'=>'required',
			'reorder_level'=>'required',
		])->validate();
		Size::create([
			'name'=>$this->state['name'],
			'sku'=>$this->state['sku'],
			'status'=>$this->state['status'],
			'product_id'=>$this->state['product_id'],
			'reorder_level'=>$this->state['reorder_level'],
			'taxable'=>$this->taxable,
		]);
		$this->state=[];
		$this->state['status']=true;
        $this->taxable=1;
        (new LogsService('created new size' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideSizeModal',['message'=>'Size Created Successfully!']);
	}



	public function changeToUpdatingMode($sizeId){
		$this->sizeId=$sizeId;
		$size=size::find($sizeId);

		$product=$size->product;
        $this->category_id=$size->product->category_id;
		$this->state['name']=$size->name;
		$this->state['status']=$size->status;
		$this->state['sku']=$size->sku;
		$this->state['product_id']=$size->product_id;
		$this->state['reorder_level']=$size->reorder_level;
		$this->taxable=$size->taxable;
		$this->updatingMode=true;
		$this->viewingMode=false;
		$this->dispatchBrowserEvent('showSizeModal');
	}

	public function updateSize(){
		$size=size::find($this->sizeId);
        $attribute_sizes=ProductsAttribute::where('size_id',$this->sizeId)->get();
		$validatedData=Validator::make($this->state,[
			'name'=>'required',
			'sku'=>'required|unique:sizes,sku,'.$this->sizeId,
			'product_id'=>'required',
			'reorder_level'=>'required',
		])->validate();

		$size->update([
			'name'=>$this->state['name'],
			'status'=>$this->state['status'],
			'sku'=>$this->state['sku'],
			'product_id'=>$this->state['product_id'],
			'reorder_level'=>$this->state['reorder_level'],
			'taxable'=>$this->taxable,
		]);

        foreach ($attribute_sizes as $attSize){
            $attSize->update([
                'size'=>$this->state['name'],
                'sku'=>$this->state['sku'],
            ]);
        }

		$this->state=[];
		$this->state['status']=true;
		$this->taxable=1;
        (new LogsService('updated size' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideSizeModal',['message'=>'Size Updated successfully!']);
	}

	public function updatedSorting(){
		$this->resetPage();
	}
	public function updatedSearch(){
		$this->resetPage();
	}

    public function render()
    {
        $allSettings=GeneralSetting::all();
        if ($allSettings->isEmpty()){
            $setting=null;
        }else{
            $setting=$allSettings->first();
        }

        $setTaxPercentage=$setting ? $setting->tax_percentage : null;
        $this->tax_percentage=$this->taxable==1? $setTaxPercentage." %" : "0 %";

    	if ($this->sorting=="default") {
    		if ($this->search=='') {
    			$sizes=Size::latest()->paginate($this->pagesize);
    		} else {
    			$product=Product::search('name',$this->search)->first();
    			if ($product) {
    				$product_id=$product->id;
    				$sizes=Size::where('product_id',$product_id)->latest()->paginate($this->pagesize);
    			} else {
    				$product_id=NULL;
    				$sizes=Size::where('product_id',$product_id)->latest()->paginate($this->pagesize);
    			}



    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$sizes=Size::where('status',1)->paginate($this->pagesize);
    		} else {
    			$product=Product::search('name',$this->search)->first();
    			if ($product) {
    				$product_id=$product->id;
    				$sizes=Size::where('product_id',$product_id)->where('status',1)->latest()->paginate($this->pagesize);
    			} else {
    				$product_id=NULL;
    				$sizes=Size::where('product_id',$product_id)->where('status',1)->latest()->paginate($this->pagesize);
    			}
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$sizes=Size::where('status',0)->paginate($this->pagesize);
    		} else {
    			$product=Product::search('name',$this->search)->first();
    			if ($product) {
    				$product_id=$product->id;
    				$sizes=Size::where('product_id',$product_id)->where('status',0)->latest()->paginate($this->pagesize);
    			} else {
    				$product_id=NULL;
    				$sizes=Size::where('product_id',$product_id)->where('status',0)->latest()->paginate($this->pagesize);
    			}
    		}

    	}else{
    		$sizes=Size::latest()->paginate($this->pagesize);
    	}

    	$count=Size::all();
    	$categories=Category::all();
    	$products=Product::where('category_id',$this->category_id)->get();
        return view('livewire.admin-size-component',['sizes'=>$sizes,'count'=>$count,'categories'=>$categories,'products'=>$products])->layout('layouts.admin');
    }
}
