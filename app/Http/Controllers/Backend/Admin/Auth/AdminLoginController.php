<?php

namespace App\Http\Controllers\Backend\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:super_admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // return $request;
        // Validate form data
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('super_admin.dashboard'));
        }

        // if unsuccessful
        $errors = [
            'username' => 'username or password is incorrect',
        ];
        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
    }

    // public function logout(Request $request)
    // {
    //     auth::logout();
    //     $request->session()->invalidate();
    //     return redirect(route('admin.login'));
    // }
}
