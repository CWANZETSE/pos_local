<?php

namespace App\Http\Livewire;

use App\Services\LogsService;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Size;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
class AdminBranchComponent extends Component
{

	use WithPagination;
	protected $paginationTheme = 'bootstrap';

	public $updatingMode=false;
	public $error=false;
	public $viewingMode=false;
	public $state=[];
	public $branchId;
	public $sorting='default';
	public $pagesize=5;
	public $search='';
	public $categoryStatus;
	public $branchExists;





	public function mount(){
		$this->state['till_status']=false;
		$branches=Branch::all();
		$this->branchExists=$branches->count()>0?true:false;

	}
	public function showCreateBranchModal(){
		$this->state=[];
		$this->updatingMode=false;
		$this->viewingMode=false;
		$this->state['status']=true;
		$this->dispatchBrowserEvent('showBranchModal');
	}
	public function AddBranch(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:branches',
			'location'=>'required',
		])->validate();
		$branches=Branch::all();

        Branch::create([
            'name'=>$this->state['name'],
            'till_status'=>$this->state['till_status'],
            'location'=>$this->state['location'],
            'unbanked_balance'=>0,
        ]);
        $this->branchExists = true;


		$this->state=[];
		$this->state['till_status']=false;
        (new LogsService('created branch','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideBranchModal',['message'=>'Branch Created Successfully!']);
	}



	public function changeToUpdatingMode($branchId){
		$this->branchId=$branchId;

		$branch=Branch::find($branchId);


		$this->state['name']=$branch->name;
		$this->state['till_status']=$branch->till_status;
		$this->state['location']=$branch->location;
		$this->state['unbanked_balance']=$branch->unbanked_balance;
		$this->updatingMode=true;
		$this->dispatchBrowserEvent('showBranchModal');
	}

	public function updateBranch(){
		$branch=Branch::find($this->branchId);
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:branches,name,'.$this->branchId,
		])->validate();
		$branch->update([

			'name'=>$this->state['name'],
			'till_status'=>$this->state['till_status'],
			'location'=>$this->state['location'],
			'unbanked_balance'=>$this->state['unbanked_balance'],
		]);


		$this->state=[];
		$this->state['till_status']=false;
        (new LogsService('updated branch','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideBranchModal',['message'=>'Branch  Updated Succesfully!']);
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
    			$branches=Branch::latest()->paginate($this->pagesize);
    		} else {
    			$branches=Branch::where('name','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$branches=Branch::where('till_status',1)->paginate($this->pagesize);
    		} else {
    			$branches=Branch::where('name','LIKE','%'.$this->search.'%')->where('till_status',1)->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$branches=Branch::where('till_status',0)->paginate($this->pagesize);
    		} else {
    			$branches=Branch::where('name','LIKE','%'.$this->search.'%')->where('till_status',0)->paginate($this->pagesize);
    		}

    	}else{
    		$branches=Branch::latest()->paginate($this->pagesize);
    	}

    	$count=Branch::all();
        return view('livewire.admin-branch-component',['branches'=>$branches,'count'=>$count])->layout('layouts.admin');
    }
}
