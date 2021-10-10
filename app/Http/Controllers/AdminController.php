<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function loginForm(){
        return view('admin-login');
    }


    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'username'   => 'required',
        'password' => 'required|min:6'
      ]);



      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password,'status'=>1], $request->remember)) {
        $admin=Admin::where('username',$request->username)->first();
        $admin->update(
          [
            'last_login'=>now(),
            'last_login_ip'=>$request->ip(),
          ]);
        // if successful, then redirect to their intended location
        return redirect()->route('admin.home');
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()
      ->withInput($request->only('username', 'remember'))
      ->withErrors(['message' => 'Invalid Credentials',]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        // session()->flush();
        return redirect()->route('admin.login');
    }
}
