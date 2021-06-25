<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends Controller
{
    //Sends Password Reset emails
    use SendsPasswordResetEmails;

    //Shows form to request password reset
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    //Password Broker for Admin Model
    public function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return Password::broker('admins');
    }
}
