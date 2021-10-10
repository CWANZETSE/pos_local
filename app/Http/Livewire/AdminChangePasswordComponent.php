<?php

namespace App\Http\Livewire;

use App\Services\LogsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminChangePasswordComponent extends Component
{
    public $oldPassword;
    public $newPassword;
    public $repeatNewPassword;

    protected $rules = [
        'oldPassword' => 'required',
        'newPassword' => 'required|min:6',
        'repeatNewPassword' => 'required|min:6',
    ];

    public function mount(){
        Auth::check()?:abort(403);
    }

    public function viewChangePasswordModal(){
        $this->dispatchBrowserEvent('viewAdminChangePasswordModalEvent');
    }


    public function changePassword(){
        $this->validate();
        if (Hash::check($this->oldPassword, Auth::user()->password)) {
            if (strcmp( $this->newPassword, $this->repeatNewPassword )==0) {
                $user=Auth::user();
                $user->update(['password'=>bcrypt($this->newPassword)]);
                $this->newPassword="";
                $this->repeatNewPassword="";
                $this->oldPassword="";
                (new LogsService('changed own password','Admin'))->storeLogs();
                $this->dispatchBrowserEvent('showAdminSuccessUpdatingPassword',['message'=>'Password Changed Successfully!','type'=>'success']);
            }else{
                (new LogsService('own password change attempted','Admin'))->storeLogs();
                $this->dispatchBrowserEvent('showAdminNonMatchingPasswordError',['message'=>'Passwords do not match!','type'=>'error']);
            }
        }else{
            (new LogsService('own password change attempted','Admin'))->storeLogs();
            $this->dispatchBrowserEvent('showAdminWrongOldPasswordError',['message'=>'Old password is incorrect!','type'=>'error']);
        }
    }
    public function render()
    {
        return view('livewire.admin-change-password-component')->layout('layouts.admin');
    }
}
