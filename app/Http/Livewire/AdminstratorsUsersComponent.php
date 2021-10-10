<?php

namespace App\Http\Livewire;

use App\Models\GeneralSetting;
use App\Models\Log;
use App\Models\User;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Branch;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use PDF;
class AdminstratorsUsersComponent extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $date_from;
    public $date_to;
    public $perPage;
    public $reportReady;
    public $selectedPeriod="Select date from options";
	public $updatingMode;
	public $state=[];
	public $adminId;
	public $search;
	public $sorting;
	public $pagesize=10;
	public $role_id;
	public $branch_id;
    public $user_id;
    public $model;


	public function mount(){
		$this->updatingMode=false;
		$this->state['status']=true;
		$this->search="";
		$this->sorting="default";
		$this->role_id="";
		$this->branch_id="";
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

	public function showCreateAdminModal(){

		$this->dispatchBrowserEvent('showAdminModal');
	}

	public function AddAdmin(){
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:users',
			'email'=>'required|email|unique:users',
			'username'=>'required|unique:users',
			'phone'=>'required',
			'password'=>'required|min:6',
		])->validate();
		Admin::create([
			'name'=>$this->state['name'],
			'email'=>$this->state['email'],
			'username'=>$this->state['username'],
			'phone'=>$this->state['phone'],
			'status'=>$this->state['status'],
			'role_id'=>$this->role_id,
			'branch_id'=>$this->branch_id,
			'password'=>bcrypt($this->state['password']),
		]);
		$this->state=[];
		$this->state['status']=true;
        (new LogsService('created new admin' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideAdminModal',['message'=>'Admin Created Successfully!']);
	}

	public function changeToUpdatingMode($id){
		$this->updatingMode=true;
		$this->adminId=$id;
		$admin=Admin::find($id);
		$this->state['name']=$admin->name;
		$this->state['email']=$admin->email;
		$this->state['username']=$admin->username;
		$this->state['phone']=$admin->phone;
		$this->state['status']=$admin->status;
		$this->role_id=$admin->role_id;;
		$this->branch_id=$admin->branch_id;
		$this->dispatchBrowserEvent('showAdminModal');
	}

	public function updatedRoleId(){
	    $this->branch_id="";
    }

	public function updateAdmin(){
		$user=Admin::find($this->adminId);
		$validatedData=Validator::make($this->state,[
			'name'=>'required|unique:users,name,'.$this->adminId,
			'email'=>'required|email|unique:users,email,'.$this->adminId,
			'username'=>'required|unique:users,username,'.$this->adminId,
			'phone'=>'required',
		])->validate();

		if($user->id===auth()->user()->id){
            $this->dispatchBrowserEvent('ErrorUpdatingAdmin',['message'=>'Sorry, you are not allowed to update this user']);
            return false;
        }
		$user->update([
			'name'=>$this->state['name'],
			'email'=>$this->state['email'],
			'username'=>$this->state['username'],
			'phone'=>$this->state['phone'],
			'status'=>$this->state['status'],
            'role_id'=>$this->role_id,
            'branch_id'=>$this->role_id==1? null: $this->branch_id,
		]);
		$this->state=[];
		$this->state['status']=true;
		$this->updatingMode=false;
        (new LogsService('updated admin' ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('hideAdminModal',['message'=>'Admin Updated Successfully!']);
	}

	public function changeAdminPassword($id){
		$user=Admin::findOrFail($id);
		$user->update(['password'=>bcrypt('password')]);
        (new LogsService('updated password '.$user->username ,'Admin'))->storeLogs();
		$this->dispatchBrowserEvent('successUpdatingPassword',['message'=>'Password Updated Successfully!','type'=>'success']);
	}

	public function updatedSorting(){
		$this->resetPage();
	}
	public function updatedSearch(){
		$this->resetPage();
	}

    public function ShowUserlogsModal($user_id){
        $this->user_id=$user_id;
        $this->date_from="";
        $this->date_to="";
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
            ->where('model','Admin')
            ->whereBetween('created_at', [$from, $to])
            ->paginate($this->perPage);
        $user_name=Admin::find($this->user_id)->name;

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
    	if ($this->sorting==="default") {
    		if ($this->search=='') {
    			$admins=Admin::latest()->paginate($this->pagesize);
    		} else {
    			$admins=Admin::where('name','LIKE','%'.$this->search.'%')->latest()->latest()->paginate($this->pagesize);
    		}
    	} else if($this->sorting=="active") {
    		if ($this->search=='') {
    			$admins=Admin::where('status',1)->latest()->paginate($this->pagesize);
    		} else {
    			$admins=Admin::where('name','LIKE','%'.$this->search.'%')->where('status',1)->latest()->paginate($this->pagesize);
    		}

    	}else if($this->sorting=="disabled") {
    		if ($this->search=='') {
    			$admins=Admin::where('status',0)->latest()->paginate($this->pagesize);
    		} else {
    			$admins=Admin::where('name','LIKE','%'.$this->search.'%')->where('status',0)->latest()->paginate($this->pagesize);
    		}

    	}else{
    		$admins=Admin::latest()->paginate($this->pagesize);
    	}
    	$branches=Branch::all();

    	$count=Admin::all()->count();

        $from    = Carbon::parse($this->date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($this->date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        if ($this->date_from!="" && $this->date_to!="") {
            $user_data=Log::where('user_id',$this->user_id)
                ->where('model','Admin')
                ->whereBetween('created_at', [$from, $to])
                ->paginate($this->perPage);
            $user_name=Admin::find($this->user_id)->name;
            $this->reportReady=true;
        }else{
            $user_data=[];
            $user_name='';
            $this->reportReady=false;
        }
        return view('livewire.adminstrators-users-component',compact(['admins','count','branches','user_data','user_name']))->layout('layouts.admin');
    }
}
