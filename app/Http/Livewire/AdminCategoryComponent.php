<?php

namespace App\Http\Livewire;
use App\Services\LogsService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use Livewire\WithPagination;
use Auth;

class AdminCategoryComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $category_orders=0;
	public $category_stock=0;
	public $updatingMode=false;
	public $error=false;
	public $viewingMode=false;
	public $state=[];
	public $categoryId;
	public $sorting='default';
	public $pagesize=5;
	public $search='';





	public function mount(){
		$this->state['status']=true;
	}
	public function showCreateCategoryModal(){
		$this->state=[];
		$this->updatingMode=false;
		$this->viewingMode=false;
		$this->state['status']=true;
		$this->dispatchBrowserEvent('showCategoryModal');
	}
	public function AddCategory(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:categories',
			'description'=>'required',
		])->validate();
		Category::create([
			'name'=>$this->state['name'],
			'status'=>$this->state['status'],
			'description'=>$this->state['description'],
		]);
		$this->state=[];
		$this->state['status']=true;
        (new LogsService('created category','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideCategoryModal',['message'=>'Category created successfully!']);
	}



	public function changeToUpdatingMode($catId){
		$this->categoryId=$catId;
		$category=Category::find($catId);

		$this->state['name']=$category->name;
		$this->state['status']=$category->status;
		$this->state['description']=$category->description;
		$this->updatingMode=true;
		$this->viewingMode=false;
		$this->dispatchBrowserEvent('showCategoryModal');
	}

	public function updateCategory(){
		$category=Category::find($this->categoryId);
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:categories,name,'.$this->categoryId,
			'description'=>'required',
		])->validate();
		$category->update([

			'name'=>$this->state['name'],
			'status'=>$this->state['status'],
			'featured'=>$this->state['description']
		]);

		$categoryProducts=$category->products;
		//enable/disable children dependant
		foreach ($categoryProducts as $key => $product) {
			$product->update([
				'status'=>$this->state['status'],
			]);
		}
		//end enable/disable children dependant
		$this->state=[];
		$this->state['status']=true;
        (new LogsService('updated category','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideCategoryModal',['message'=>'Category updated successfully']);
	}

	public function changeToViewMode($catId){
		$this->categoryId=$catId;
		$category=Category::find($catId);

		$this->state['name']=$category->name;
		$this->state['status']=$category->status;
		$this->state['description']=$category->description;
		$this->viewingMode=true;
		$this->dispatchBrowserEvent('showCategoryModal');
	}

	public function updatedSorting(){
		$this->resetPage();
	}

    public function render()
    {

    	if ($this->sorting=="default") {
    		if ($this->search=='') {
    			$categories=Category::latest()->paginate($this->pagesize);
    		} else {
    			$categories=Category::where('name','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$categories=Category::where('status',1)->paginate($this->pagesize);
    		} else {
    			$categories=Category::where('name','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$categories=Category::where('status',0)->paginate($this->pagesize);
    		} else {
    			$categories=Category::where('name','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
    		}

    	}else{
    		$categories=Category::latest()->paginate($this->pagesize);
    	}

    	$count=Category::all();
    	$products=Product::all();

        return view('livewire.admin-category-component',['categories'=>$categories,'count'=>$count,'products'=>$products])->layout('layouts.admin');
    }
}
