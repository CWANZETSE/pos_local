<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Shift;
use App\Models\User;
use App\Services\LogsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AdminUserViewProfileComponent extends Component
{
    public $updatingMode;
    public $branch_id;
    public $state=[];
    public $cashierId;
    public $cashier=[];
    public $search;
    public $sorting;
    public $pagesize=10;
    public $user_id;
    public $model;


    protected $listeners = ['ViewUserProfileEvent' => 'ViewUserProfile'];

    public function mount(){
        $this->GetFirstUser();
    }

    public function GetFirstUser(){
        $userId=User::count()>0?User::first()->id:null;
        $this->cashier=User::count()>0?User::first():[];
        $this->ViewUserProfile($userId);
    }

    public function ViewUserProfile($cashierId){
        $this->cashierId=$cashierId;
        $cashier=User::count()>0?User::find($cashierId):null;
        $this->cashier=User::count()>0?User::find($cashierId):null;
        $this->state['name']=$cashier!==null?$cashier->name:'';
        $this->state['email']=$cashier!==null?$cashier->email:'';
        $this->state['username']=$cashier!==null?$cashier->username:'';
        $this->state['branch_id']=$cashier!==null?$cashier->branch_id:'';
        $this->state['phone']=$cashier!==null?$cashier->phone:'';
        $this->state['assigned_till']=$cashier!==null?$cashier->assigned_till:'';
        $this->state['print_receipt']=$cashier!==null?$cashier->print_receipt:'';
        $this->state['status']=$cashier!==null?$cashier->status:'';
        $this->state['printer_ip']=$cashier!==null?$cashier->printer_ip:'';
        $this->state['created_at']=$cashier!==null?Carbon::parse($cashier->created_at)->toDayDateTimeString():'';
        $this->state['printer_port']=$cashier!==null?$cashier->printer_port:'';
        $this->dispatchBrowserEvent('showCashierModal');
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
            'shift_opened'=> \Illuminate\Support\Carbon::now(),
            'shift_closed'=>null,
        ]);
        $user->update([
            'assigned_till'=>1,
        ]);
        $this->cashier=$user;
        $this->state['assigned_till']=$user->assigned_till;
        $this->emit('TillUpdatedEvent');
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
        $this->cashier=$user;
        $this->state['assigned_till']=$user->assigned_till;
        $this->emit('TillUpdatedEvent');
        (new LogsService('shift close for '.$user->username,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successClosingShiftEvent',['message'=>'Shift Closed Successfully!','type'=>'success']);
    }

    public function changeCashierPassword($id){
        $user=User::findOrFail($id);
        $user->update(['password'=>bcrypt('password')]);
        (new LogsService('changed cashier password','Admin'))->storeLogs();
        $this->dispatchBrowserEvent('successUpdatingPassword',['message'=>'Password Updated Successfully!','type'=>'success']);
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
            'status'=>'required',
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
        (new LogsService('updated cashier '.$user->username,'Admin'))->storeLogs();
        $this->dispatchBrowserEvent('hideCashierModal',['message'=>'Cashier Updated Successfully!']);
    }


    public function render()
    {
        $branches=Branch::all();
        return view('livewire.admin-user-view-profile-component',compact(['branches']))->layout('layouts.admin');
    }
}
