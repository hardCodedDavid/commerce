<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public static function initializeTransaction($amount, $data): \Illuminate\Http\RedirectResponse
    {
        $paymentData = [
            'amount' => $amount * 100,
            'reference' => Paystack::genTranxRef(),
            'email' => $data['email'],
            'currency' => 'NGN',
            'metadata' => json_encode($data)
        ];
        Payment::create([
            'user_id' => auth()->user()['id'] ?? null,
            'reference' => $paymentData['reference'],
            'amount' => $amount,
            'meta' => json_encode($data)
        ]);
        \request()->merge($paymentData);
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return back()->with('error', 'The paystack token has expired. Please refresh the page and try again.');
        }
    }

    public function handlePaymentCallback(): \Illuminate\Http\RedirectResponse
    {
        $paymentDetails = Paystack::getPaymentData();
        $res = $paymentDetails['data'];
        $payment = Payment::query()->where('reference', $res['reference'])->first();
        try {
            if (isset($paymentDetails['status'])) {
                if (isset($res)) {
                    if ($res["status"] == 'success') {

                    } else {

                    }
                }
            }
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return redirect()->route('transactions')->with('error', 'Transaction failed');
        }
        return redirect()->route('transactions')->with('error', 'Error completing transaction');
    }
}
