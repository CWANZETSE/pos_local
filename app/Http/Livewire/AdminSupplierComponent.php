<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use App\Models\SupplierBank;
use App\Services\LogsService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
class AdminSupplierComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $product_orders=0;
	public $product_stock=0;
	public $updatingMode=false;
	public $updatingBankMode=false;
	public $error=false;
	public $viewingMode=false;
	public $state=[];
	public $supplierId;
	public $sorting='default';
	public $pagesize=10;
	public $search='';
	public $categoryStatus;

	public $supplier_name;
	public $bank_supplier_name;
	public $supplier_code;
	public $total_invoices_amt;
	public $paid_invoices_amt;
	public $pending_invoices_amt;

    public $total_invoices_count;
    public $paid_invoices_count;
    public $pending_invoices_count;

	public $first_created;
	public $last_created;
	public $last_paid;
	public $supplier_id;
	public $bank_details=[];
	public $bank_id;

	public $new_bank_name;
	public $new_account_number;
	public $new_bank_additional_details;





	public function mount(){
		$this->state['status']=true;
		$this->categoryStatus=false;
        $this->updatingBankMode=false;
	}
	public function showCreateSupplierModal(){
		$this->state=[];
		$this->updatingMode=false;
		$this->viewingMode=false;
		$this->state['status']=true;
		$this->dispatchBrowserEvent('showSupplierModal');
	}
	public function AddSupplier(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required',
			'email'=>'required|email|unique:suppliers',
			'contact'=>'required',
			'address'=>'required',
			'invoice_due_days'=>'required',
		])->validate();
		Supplier::create([
			'name'=>$this->state['name'],
			'address'=>$this->state['address'],
			'contact'=>$this->state['contact'],
			'email'=>$this->state['email'],
			'status'=>$this->state['status'],
			'invoice_due_days'=>$this->state['invoice_due_days'],
			'supplier_code'=>mt_rand(10000000,99999999),
		]);
		$this->state=[];
		$this->state['status']=true;
        (new LogsService('created new supplier' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideSupplierModal',['message'=>'Supplier Created Successfully!']);
	}



	public function changeToUpdatingMode($supId){
		$this->supplierId=$supId;

		$supplier=Supplier::find($supId);

		$this->state['name']=$supplier->name;
		$this->state['address']=$supplier->address;
		$this->state['contact']=$supplier->contact;
		$this->state['email']=$supplier->email;
		$this->state['status']=$supplier->status;
		$this->state['invoice_due_days']=$supplier->invoice_due_days;
		$this->updatingMode=true;
		$this->viewingMode=false;
		$this->dispatchBrowserEvent('showSupplierModal');
	}

	public function updateSupplier(){
		$validatedData=Validator::make($this->state,[
			'email'=>'required|unique:suppliers,email,'.$this->supplierId,
			'contact'=>'required|unique:suppliers,contact,'.$this->supplierId,
			'name'=>'required|unique:suppliers,name,'.$this->supplierId,
			'invoice_due_days'=>'required',
		])->validate();
		$supplier=Supplier::find($this->supplierId);
		$supplier->update([
			'name'=>$this->state['name'],
			'address'=>$this->state['address'],
			'contact'=>$this->state['contact'],
			'email'=>$this->state['email'],
			'status'=>$this->state['status'],
			'invoice_due_days'=>$this->state['invoice_due_days'],
		]);

		$this->state=[];
		$this->state['status']=true;
        (new LogsService('updated supplier '.$supplier->supplier_code ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideSupplierModal',['message'=>'Supplier Updated Successfuly!']);
	}

	public function updatedSorting(){
		$this->resetPage();
	}
	public function updatedSearch(){
		$this->resetPage();
	}

	public function AddNewBank(){
        $validatedData=$this->validate([
            'new_bank_name'=>'required',
            'new_account_number'=>'required',
            'new_bank_additional_details'=>'required',
        ]);

        SupplierBank::create([
           'supplier_id'=>$this->supplier_id,
           'account_number'=>$this->new_account_number,
           'bank_name'=>$this->new_bank_name,
           'bank_additional_details'=>$this->new_bank_additional_details,
        ]);
        $this->bank_details=SupplierBank::where('supplier_id',$this->supplier_id)->get();
        $this->new_account_number ="";
        $this->new_bank_name ="";
        $this->new_bank_additional_details ="";

        $supplier=Supplier::find($this->supplier_id);
        (new LogsService('created new bank '.$supplier->supplier_code ,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('showSuccessEvent',['message'=>'Bank Created Successfully!']);

    }

    public function AdminViewSupplierAccountModal($supplier_id){
	    $this->supplier_id = $supplier_id;
	    $this->bank_supplier_name=Supplier::find($supplier_id)->name;
	    $this->bank_details=SupplierBank::where('supplier_id',$supplier_id)->get();
        $this->new_account_number ='';
        $this->new_bank_name ='';
        $this->new_bank_additional_details ='';
        $this->dispatchBrowserEvent('AdminViewSupplierAccountModalEvent');
    }

    public function ChangeToBankUpdatingMode($bankId){
	    $this->updatingBankMode=true;
	    $bank=SupplierBank::find($bankId);
	    $this->bank_id=$bankId;
	    $this->supplier_id=$bank->supplier->id;
        $this->new_account_number =$bank->account_number;
        $this->new_bank_name =$bank->bank_name;
        $this->new_bank_additional_details =$bank->bank_additional_details;
    }
    public function updateBank(){
        $validatedData=$this->validate([
            'new_bank_name'=>'required',
            'new_account_number'=>'required',
            'new_bank_additional_details'=>'required',
        ]);
        $bank=SupplierBank::find($this->bank_id);
        $bank->update([
            'supplier_id'=>$this->supplier_id,
            'account_number'=>$this->new_account_number,
            'bank_name'=>$this->new_bank_name,
            'bank_additional_details'=>$this->new_bank_additional_details,
        ]);
        $this->bank_details=SupplierBank::where('supplier_id',$this->supplier_id)->get();
        $this->new_account_number ="";
        $this->new_bank_name ="";
        $this->new_bank_additional_details ="";
        $this->updatingBankMode=false;
        $supplier=Supplier::find($this->supplier_id);
        (new LogsService('updated bank supplier '.$supplier->supplier_code,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('showSuccessEvent',['message'=>'Bank Details Updated Successfully!']);

    }

    public function render()
    {

    	if ($this->sorting=="default") {
    		if ($this->search=='') {
    			$suppliers=Supplier::latest()->paginate($this->pagesize);
    		} else {
    			$suppliers=Supplier::where('name','LIKE','%'.$this->search.'%')->orWhere('supplier_code','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$suppliers=Supplier::where('status',1)->paginate($this->pagesize);
    		} else {
    			$suppliers=Supplier::where('name','LIKE','%'.$this->search.'%')->orWhere('supplier_code','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$suppliers=Supplier::where('status',0)->paginate($this->pagesize);
    		} else {
    			$suppliers=Supplier::where('name','LIKE','%'.$this->search.'%')->orWhere('supplier_code','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
    		}

    	}else{
    		$suppliers=Supplier::latest()->paginate($this->pagesize);
    	}

    	$count=Supplier::all();
        return view('livewire.admin-supplier-component',['suppliers'=>$suppliers,'count'=>$count])->layout('layouts.admin');
    }
}
