<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AdminResetPasswordController extends Controller
{
    //admin redirect path
    protected $redirectTo = '/admin/dashboard';

    //trait for handling reset Password
    use ResetsPasswords;

    //Show form to admin where they can save new password
    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    //returns Password broker of admin
    public function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return Password::broker('admins');
    }

    //returns authentication guard of admin
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
