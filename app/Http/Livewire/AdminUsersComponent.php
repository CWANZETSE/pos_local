<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Shift;
use App\Services\LogsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;


class AdminUsersComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $component = '';
    public $showUserProfile=true;
    public $showUserlogs=false;
    public $showUserCreate=false;
    public $selectedUserId;
    public $search='';
    protected $listeners=['UserCreatedEvent'=>'UserCreated','TillUpdatedEvent'=>'TillUpdated'];



    public function mount(){
        $this->selectedUserId=User::count()>0?User::first()->id:null;
    }

    public function UserCreated(){
        $this->getAllUsers();
    }


    public function ViewUserProfile($cashierId){
        $this->showUserProfile=true;
        $this->showUserCreate=false;
        $this->showUserlogs=false;
        $this->selectedUserId=$cashierId;
        $this->emit('ViewUserProfileEvent',$cashierId);
    }

    public function AdminUserCreate(){
        $this->showUserProfile=false;
        $this->showUserlogs=false;
        $this->showUserCreate=true;
        $this->selectedUserId=null;
    }


    private function getAllUsers()
    {
        $adminBranchId=Auth::user()->branch_id;
        if(Auth::user()->role_id==Admin::IS_ADMINISTRATOR){
            return User::search('name',$this->search)->get();
        }else{
            return User::search('name',$this->search)->where('branch_id',$adminBranchId)->get();
        }

    }
    private function searchedUsersCount()
    {
        return User::search('name',$this->search)->count();
    }
    private function activeTillUsersCount()
    {
        return User::search('name',$this->search)->where('assigned_till',1)->count();
    }

    private function TotalUsersCount(){
        $count=User::search('name',$this->search)->count();
        if($count===0){
            return 1;
        }else{
            return $count;
        }

    }

    public function TillUpdated(){

    }


    public function render()
    {
        $cashiers=$this->getAllUsers();
        $searched_users_count=$this->searchedUsersCount();
        $active_till_users_count=$this->activeTillUsersCount();
        $total_users_count=$this->totalUsersCount();

        return view('livewire.admin-users-component', compact(['cashiers','searched_users_count','active_till_users_count','total_users_count']))->layout('layouts.admin');
    }

}
