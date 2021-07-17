<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyEmail()
    {
        return view('auth.verify');
    }

    public function confirmVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    public function resendVerifyEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', 'Verification link sent!');
    }
}