<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:admin', 'guest'])->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        if(Auth::guard('admin')->attempt(['email' => $request['email'], 'password' => $request['password']], $request['remember']))
        {
            return redirect()->intended(route('admin.dashboard'));
        }

        // if unsuccessful
        return redirect()->back()->withInput($request->only('email','remember'))->withErrors(['email' => 'These credentials do not match our records']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
