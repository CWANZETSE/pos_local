<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Declarations;
use App\Models\User;
use App\Services\CashierUndeclaredCashService;
use App\Services\LogsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use PhpParser\Builder\Declaration;

class AdminReconciliationComponent extends Component
{
    public $comments;
    public $status;
    public $cashierUndeclared;
    public $branch_id;
    public $declaration_id;
    public $successUpdating=false;
    public $errorUpdating=false;
    public $users=[];
    public $selected_branch_id;
    public $user_id;
    public $amount=0;
    public $checked=false;
    public $ifFloat=false;
    public $readyForSaving=false;


    public function UpdatedAmount(){
        if($this->amount==null){
            $this->amount=0;
        }
    }

    public function showCheckCashierDepositModal($id){
        $this->declaration_id=$id;
        $declaration=Declarations::find($id)->float;
        $this->ifFloat=$declaration;
        $this->dispatchBrowserEvent('showCheckCashierDepositModalEvent');
    }

    public function DecisionOnDeposit(){

        if($this->status=="" || $this->comments==""){
            $this->errorUpdating=true;
            $this->successUpdating=false;
        }else{
            $declaration=Declarations::find($this->declaration_id);
            $declaration->update([
                'status'=>$this->status,
                'comments'=>$this->comments,
                'admin_id'=>Auth::user()->id,
            ]);
            $this->status="";
            $this->comments="";
            $this->successUpdating=true;
            $this->errorUpdating=false;
            $this->dispatchBrowserEvent('successDecisoningDepositEvent');
        }

    }

    public function CreateFloat(){
        $this->dispatchBrowserEvent('showFloatModalEvent');
    }

    public function updatedSelectedBranchId(){
        $this->user_id="";
        $this->users=User::where('branch_id',$this->selected_branch_id)->get();
    }

    public function SaveFloat(){
            Declarations::create([
                'user_id'=>$this->user_id,
                'branch_id'=>$this->selected_branch_id,
                'txn_date'=>Carbon::now(),
                'amount'=>$this->amount,
                'reference'=>mt_rand(1000000000,9999999999),
                'destination'=>'Float',
                'float'=>1,
                'details'=>Auth::user()->username,
            ]);
            $user=User::find($this->user_id)->username;
            $this->selected_branch_id="";
            $this->user_id="";
            $this->amount=0;
            $this->checked=false;
        (new LogsService('created float '.$user ,'Admin'))->storeLogs();
            $this->dispatchBrowserEvent('messageSavingFloatEvent',['message'=>"Success Creating Float ",'type'=>'success']);

    }

    public function CheckIfReady(){
        if($this->amount<=0 || $this->selected_branch_id==="" || $this->user_id===""){
            $this->checked=false;
            return false;
        }else{
            return true;
        }
    }

    public function render()
    {
        $this->readyForSaving=$this->CheckIfReady();
        $AdminBranchId=auth()->user()->branch_id;
        $date_from=date('Y-m-d');
        $date_to=date('Y-m-d');
        $from    = Carbon::parse($date_from)
            ->startOfDay()        // 2018-09-29 00:00:00.000000
            ->toDateTimeString(); // 2018-09-29 00:00:00
        $to      = Carbon::parse($date_to)
            ->endOfDay()          // 2018-09-29 23:59:59.000000
            ->toDateTimeString(); // 2018-09-29 23:59:59
        $ManageBranchId=Auth::user()->role_id==Admin::IS_MANAGER?Auth::user()->branch_id:null;

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $pendingDeclarations=Declarations::where('status',Declarations::IS_PENDING)
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$ManageBranchId)
                ->orderBy('id', 'DESC')
                ->get();
            $approvedDeclarations=Declarations::where('status',Declarations::IS_APPROVED)
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$ManageBranchId)
                ->orderBy('id', 'DESC')
                ->get();
            $declinedDeclarations=Declarations::where('status',Declarations::IS_REJECTED)
                ->whereBetween('created_at', [$from, $to])
                ->where('branch_id',$ManageBranchId)
                ->orderBy('id', 'DESC')
                ->get();
        }else{
            $pendingDeclarations=Declarations::where('status',Declarations::IS_PENDING)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id', 'DESC')
                ->get();
            $approvedDeclarations=Declarations::where('status',Declarations::IS_APPROVED)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id', 'DESC')
                ->get();
            $declinedDeclarations=Declarations::where('status',Declarations::IS_REJECTED)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id', 'DESC')
                ->get();
        }

        if (Auth::user()->role_id==Admin::IS_MANAGER){
            $branches=Branch::where('id',$AdminBranchId)->get();
        }else{
            $branches=Branch::all();
        }

        return view('livewire.admin-reconciliation-component',compact(['pendingDeclarations','approvedDeclarations','declinedDeclarations','branches']))->layout('layouts.admin');
    }
}
