<?php

namespace App\Http\Livewire;

use App\Services\LogsService;
use Livewire\Component;
use App\Models\Product;
use App\Models\Size;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
class AdminProductComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $product_orders=0;
	public $product_stock=0;
	public $updatingMode=false;
	public $error=false;
	public $viewingMode=false;
	public $state=[];
	public $productId;
	public $sorting='default';
	public $pagesize=5;
	public $search='';
	public $categoryStatus;





	public function mount(){
		$this->state['status']=true;
		$this->categoryStatus=false;
	}
	public function showCreateProductModal(){
		$this->state=[];
		$this->updatingMode=false;
		$this->viewingMode=false;
		$this->state['status']=true;
		$this->dispatchBrowserEvent('showProductModal');
	}
	public function AddProduct(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:products',
			'category_id'=>'required',
		])->validate();
		Product::create([
			'name'=>$this->state['name'],
			'status'=>$this->state['status'],
			'category_id'=>$this->state['category_id'],
		]);
		$this->state=[];
		$this->state['status']=true;
        (new LogsService('created product' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideProductModal',['message'=>'Product Created Successfully!']);
	}



	public function changeToUpdatingMode($prodId){
		$this->productId=$prodId;

		$product=Product::find($prodId);


		$this->state['name']=$product->name;
		$this->state['status']=$product->status;
		$this->state['category_id']=$product->category_id;
		$this->updatingMode=true;
		$this->viewingMode=false;
		$this->dispatchBrowserEvent('showProductModal');
	}

	public function updateProduct(){
		$product=Product::find($this->productId);
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:products,name,'.$this->productId,
			'category_id'=>'required',
		])->validate();
		$product->update([

			'name'=>$this->state['name'],
			'status'=>$this->state['status'],
			'category_id'=>$this->state['category_id']
		]);


		$this->state=[];
		$this->state['status']=true;
        (new LogsService('updated product' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideProductModal',['message'=>'Product updated successfuly']);
	}

	public function chanProducteToViewMode($catId){
		$this->productId=$catId;
		$product=Product::find($catId);

		$this->state['name']=$product->name;
		$this->state['status']=$product->status;
		$this->state['category_id']=$product->category_id;
		$this->viewingMode=true;
		$this->dispatchBrowserEvent('showProductModal');
	}

	public function updatedSorting(){
		$this->resetPage();
	}
	public function updatedSearch(){
		$this->resetPage();
	}

    public function render()
    {

    	if ($this->sorting=="default") {
    		if ($this->search=='') {
    			$products=Product::latest()->paginate($this->pagesize);
    		} else {
    			$products=Product::where('name','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$products=Product::where('status',1)->paginate($this->pagesize);
    		} else {
    			$products=Product::where('name','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$products=Product::where('status',0)->paginate($this->pagesize);
    		} else {
    			$products=Product::where('name','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
    		}

    	}else{
    		$products=Product::latest()->paginate($this->pagesize);
    	}

    	$count=Product::all();
    	$sizes=Size::all();
    	$categories=Category::all();
        return view('livewire.admin-product-component',['products'=>$products,'count'=>$count,'sizes'=>$sizes,'categories'=>$categories])->layout('layouts.admin');
    }
}
