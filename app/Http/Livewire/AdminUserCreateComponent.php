<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\User;
use App\Services\LogsService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AdminUserCreateComponent extends Component
{
    public $updatingMode;
    public $branch_id;
    public $state=[];
    public $cashierId;
    public $search;
    public $sorting;
    public $pagesize=10;
    public $user_id;
    public $model;



    public function AddCashier(){
        $validatedData=Validator::make($this->state,[
            'name'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'username'=>'required|unique:users',
            'branch_id'=>'required',
            'phone'=>'required',
            'printer_ip'=>'required',
            'print_receipt'=>'required',
            'status'=>'required',
            'printer_port'=>'required',
            'password'=>'required|min:6',
        ])->validate();
        User::create([
            'name'=>$this->state['name'],
            'email'=>$this->state['email'],
            'username'=>$this->state['username'],
            'branch_id'=>$this->state['branch_id'],
            'phone'=>$this->state['phone'],
            'print_receipt'=>$this->state['print_receipt'],
            'status'=>$this->state['status'],
            'printer_ip'=>$this->state['printer_ip'],
            'printer_port'=>$this->state['printer_port'],
            'password'=>bcrypt($this->state['password']),
        ]);
        $this->state=[];
        $this->state['status']=true;
        $this->emit('UserCreatedEvent');
        (new LogsService('created cashier','Admin'))->storeLogs();
        $this->dispatchBrowserEvent('hideCashierModal',['message'=>'Cashier Created Successfully!']);
    }



    public function render()
    {
        $branches=Branch::all();
        return view('livewire.admin-user-create-component',compact(['branches']))->layout('layouts.admin');
    }
}
