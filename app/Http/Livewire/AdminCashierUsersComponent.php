<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\Log;
use App\Models\Shift;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use PDF;


class AdminCashierUsersComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $date_from;
    public $date_to;
    public $perPage=10;
    public $reportReady;
    public $selectedPeriod="Select date from options";
	public $updatingMode;
	public $branch_id;
	public $state=[];
	public $cashierId;
	public $search;
	public $sorting;
	public $pagesize=10;
	public $user_id;
	public $model;

	public function mount(){
		$this->updatingMode=false;
		$this->state['status']=true;
		$this->state['assigned_till']=false;
		$this->state['print_receipt']=false;
		$this->search="";
		$this->sorting="default";
		$this->perPage=10;
	}

    public function ShowDateRangeModal(){
        $this->dispatchBrowserEvent('ShowDateRangeModalEvent');
    }
    public function PredefinedPeriod($str){
        $this->reportReady= !($this->branch_id === null) && !($this->branch_id === "");
        $this->resetPage();
        if($str==="today"){
            $this->selectedPeriod='Today';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $time='Day';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="yesterday"){
            $this->selectedPeriod='Yesterday';
            $date_from=Carbon::yesterday();
            $date_to=Carbon::yesterday();
            $time='Day';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="this_week"){
            $this->selectedPeriod='This Week';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $time='Week';
            $this->FillDateRange($date_from,$date_to,$time);
        }else if($str==="last_week"){
            $this->selectedPeriod='Last Week';
            $date_from=Carbon::now()->subWeek();
            $date_to=Carbon::now()->subWeek();
            $this->date_from = Carbon::parse($date_from)
                ->startOfWeek()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfWeek()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="this_month"){
            $this->selectedPeriod='This Month';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $this->date_from = Carbon::parse($date_from)
                ->startOfMonth()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfMonth()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="last_month"){
            $this->selectedPeriod='Last Month';
            $date_from=Carbon::now()->subMonth();
            $date_to=Carbon::now()->subMonth();
            $this->date_from = Carbon::parse($date_from)
                ->startOfMonth()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfMonth()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="this_year"){
            $this->selectedPeriod='This Year';
            $date_from=Carbon::now();
            $date_to=Carbon::now();
            $this->date_from = Carbon::parse($date_from)
                ->startOfYear()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }else if($str==="last_year"){
            $this->selectedPeriod='Last Year';
            $date_from=Carbon::now()->subYear();
            $date_to=Carbon::now()->subYear();
            $this->date_from = Carbon::parse($date_from)
                ->startOfYear()      // 2018-09-29 00:00:00.000000
                ->toDateTimeString(); // 2018-09-29 00:00:00
            $this->date_to = Carbon::parse($date_to)
                ->endOfYear()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59

        }


    }
    public function FillDateRange($date_from,$date_to,$time): void
    {
        $start="startOf".$time;
        $end="endOf".$time;

        $this->date_from = Carbon::parse($date_from)
            ->$start()      // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $this->date_to = Carbon::parse($date_to)
            ->$end()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
    }

	public function showCreateCashierModal(){

		$this->dispatchBrowserEvent('showCashierModal');
	}

	public function AddCashier(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:users',
			'email'=>'required|email|unique:users',
			'username'=>'required|unique:users',
			'branch_id'=>'required',
			'phone'=>'required',
			'printer_ip'=>'required',
			'printer_port'=>'required',
			'password'=>'required|min:6',
		])->validate();
		User::create([
			'name'=>$this->state['name'],
			'email'=>$this->state['email'],
			'username'=>$this->state['username'],
			'branch_id'=>$this->state['branch_id'],
			'phone'=>$this->state['phone'],
			'assigned_till'=>$this->state['assigned_till'],
			'print_receipt'=>$this->state['print_receipt'],
			'status'=>$this->state['status'],
			'printer_ip'=>$this->state['printer_ip'],
			'printer_port'=>$this->state['printer_port'],
			'password'=>bcrypt($this->state['password']),
		]);
		$this->state=[];
		$this->state['status']=true;
		$this->state['assigned_till']=false;
        (new LogsService('created cashier','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideCashierModal',['message'=>'Cashier Created Successfully!']);
	}

	public function changeToUpdatingMode($id){
		$this->updatingMode=true;
		$this->cashierId=$id;
		$cashier=User::find($id);
		$this->state['name']=$cashier->name;
		$this->state['email']=$cashier->email;
		$this->state['username']=$cashier->username;
		$this->state['branch_id']=$cashier->branch_id;
		$this->state['phone']=$cashier->phone;
		$this->state['assigned_till']=$cashier->assigned_till;
		$this->state['print_receipt']=$cashier->print_receipt;
		$this->state['status']=$cashier->status;
		$this->state['printer_ip']=$cashier->printer_ip;
		$this->state['printer_port']=$cashier->printer_port;
		$this->dispatchBrowserEvent('showCashierModal');
	}

	public function updateCashier(){
		$user=User::find($this->cashierId);
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:users,name,'.$this->cashierId,
			'email'=>'required|email|unique:users,email,'.$this->cashierId,
			'username'=>'required|unique:users,username,'.$this->cashierId,
			'branch_id'=>'required',
			'phone'=>'required',
			'printer_ip'=>'required',
			'printer_port'=>'required',
		])->validate();
		$user->update([
			'name'=>$this->state['name'],
			'email'=>$this->state['email'],
			'username'=>$this->state['username'],
			'branch_id'=>$this->state['branch_id'],
			'phone'=>$this->state['phone'],
			'assigned_till'=>$this->state['assigned_till'],
			'print_receipt'=>$this->state['print_receipt'],
			'status'=>$this->state['status'],
			'printer_ip'=>$this->state['printer_ip'],
			'printer_port'=>$this->state['printer_port'],
		]);
		$this->state=[];
		$this->state['status']=true;
		$this->state['assigned_till']=false;
		$this->updatingMode=false;
        (new LogsService('updated cashier '.$user->username,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideCashierModal',['message'=>'Cashier Updated Successfully!']);
	}

	public function updatedSorting(){
		$this->resetPage();
	}
	public function updatedSearch(){
		$this->resetPage();
	}

	public function changeCashierPassword($id){
		$user=User::findOrFail($id);
		$user->update(['password'=>bcrypt('password')]);
        (new LogsService('changed cashier password','Admin'))->storeLogs();
		$this->dispatchBrowserEvent('successUpdatingPassword',['message'=>'Password Updated Successfully!','type'=>'success']);
	}

	public function OpenShiftByAdmin($cashier_id){
        $shift=new Shift();
        $user=User::find($cashier_id);
        $shift->create([
            'user_id'=>$cashier_id,
            'branch_id'=>$user->branch->id,
            'opening_admin_id'=>Auth::user()->id,
            'closing_admin_id'=>null,
            'closing_user_id'=>null,
            'shift_opened'=>Carbon::now(),
            'shift_closed'=>null,
        ]);
        $user->update([
            'assigned_till'=>1,
        ]);
        (new LogsService('shift open for '.$user->username,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successOpeningShiftEvent',['message'=>'Shift Started Successfully!','type'=>'success']);
    }

    public function CloseShiftByAdmin($cashier_id){
        $shift=Shift::where('user_id',$cashier_id)->latest()->first();
        $shift->update([
            'closing_admin_id'=>Auth::user()->id,
            'shift_closed'=>Carbon::now(),
        ]);
        $user=User::find($cashier_id);
        $user->update([
            'assigned_till'=>0,
        ]);
        (new LogsService('shift close for '.$user->username,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successClosingShiftEvent',['message'=>'Shift Closed Successfully!','type'=>'success']);
    }

    public function ShowUserlogsModal($user_id){
	    $this->date_from="";
	    $this->date_to="";
	    $this->user_id=$user_id;
        $this->dispatchBrowserEvent('ShowUserLogsModal');
    }

    public function downloadLogsPDF(){
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59

        $user_data=Log::where('user_id',$this->user_id)
            ->where('model','User')
            ->whereBetween('created_at', [$from, $to])
            ->paginate($this->perPage);
        $user_name=User::find($this->user_id)->name;

        $settingsCount = GeneralSetting::all()->count();
        if ($settingsCount == 0) {
            $logo = 'null';
        } else {
            $logo = GeneralSetting::first()->logo;
        }

        $pdfContent = PDF::loadView('pdf.logs', compact(['user_data','user_name', 'from', 'to','logo']))->output();
        return response()->streamDownload(
            fn() => print($pdfContent),
            "filename.pdf"
        );
    }
    public function render()
    {
        $AdminBranchId=auth()->user()->branch_id;
    	if ($this->sorting=="default") {
    		if ($this->search=='') {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->latest()->paginate($this->pagesize);
                }else{
                    $cashiers=User::latest()->paginate($this->pagesize);
                }
    		} else {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->where('name','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
                }else{
                    $cashiers=User::where('name','LIKE','%'.$this->search.'%')->latest()->paginate($this->pagesize);
                }

    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->where('status',1)->paginate($this->pagesize);
                }else{
                    $cashiers=User::where('status',1)->paginate($this->pagesize);
                }

    		} else {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->where('name','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
                }else{
                    $cashiers=User::where('name','LIKE','%'.$this->search.'%')->where('status',1)->paginate($this->pagesize);
                }

    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->where('status',0)->paginate($this->pagesize);
                }else{
                    $cashiers=User::where('status',0)->paginate($this->pagesize);
                }

    		} else {
                if (Auth::user()->role_id==Admin::IS_MANAGER){
                    $cashiers=User::where('branch_id',$AdminBranchId)->where('name','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
                }else{
                    $cashiers=User::where('name','LIKE','%'.$this->search.'%')->where('status',0)->paginate($this->pagesize);
                }

    		}

    	}else{
            if (Auth::user()->role_id==Admin::IS_MANAGER){
                $cashiers=User::where('branch_id',$AdminBranchId)->latest()->paginate($this->pagesize);
            }else{
                $cashiers=User::latest()->paginate($this->pagesize);
            }

    	}

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $count=User::where('branch_id',$AdminBranchId)->count();
        }else{
            $count=User::all()->count();
        }


        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }
        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!="" && $this->date_to!="") {
            $user_data=Log::where('user_id',$this->user_id)
                ->where('model','User')
                ->whereBetween('created_at', [$from, $to])
                ->paginate($this->perPage);
            $user_name=User::find($this->user_id)->name;
            $this->reportReady=true;
        }else{
            $user_data=[];
            $user_name='';
            $this->reportReady=false;
        }
        return view('livewire.admin-cashier-users-component',compact(['branches','cashiers','count','user_data','user_name']))->layout('layouts.admin');
    }
}
