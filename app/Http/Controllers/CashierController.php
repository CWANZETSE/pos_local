<?php

namespace App\Http\Controllers;

use App\Services\LogsService;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Terminal;
class CashierController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest', ['except' => ['logout']]);
    }

    public function loginForm(){
        return view('cashier-login');
    }


    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'username'   => 'required',
        'password' => 'required|min:6'
      ]);




//    =================================LOGIN=======================

            // Attempt to log the user in
            if (Auth::guard()->attempt(['username' => $request->username, 'password' => $request->password,'status' =>1], $request->remember)) {
              $user=User::where('username',$request->username)->first();
              $user->update(
                [
                  'last_login'=>now(),
                  'last_login_ip'=>$_SERVER['REMOTE_ADDR'],
//                  'last_login_mac'=>$myMAC,

                ]);

              // if successful, then redirect to their intended location
              return redirect()->route('pos');
            }

            return redirect()->back()
            ->withInput($request->only('username', 'remember'))
            ->withErrors(['message' => 'Invalid Credentials',]);


    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->forget(['pos','suspended_session']);
        return redirect()->route('login');
    }
}
