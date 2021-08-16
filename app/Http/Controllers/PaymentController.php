<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Sale;
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
            'metadata' => json_encode(collect($data)->except(['cart', 'note']))
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

    public function handlePaymentCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $res = $paymentDetails['data'];
        $payment = Payment::query()->where('reference', $res['reference'])->first();
        try {
            if (isset($paymentDetails['status'])) {
                if (isset($res)) {
                    if ($res["status"] == 'success') {
                        if ($payment && $payment['status'] == 'pending') {
                            $meta = json_decode($payment['meta'], true);
                            $order = Order::create([
                                'user_id' => auth()->user()['id'] ?? null,
                                'code' => Order::getCode(),
                                'name' => $meta['name'],
                                'email' => $meta['email'],
                                'phone' => $meta['phone'],
                                'country' => $meta['country'],
                                'state' => $meta['state'],
                                'city' => $meta['city'],
                                'address' => $meta['address'],
                                'note' => $meta['note'],
                                'total' => $meta['cart']['total']
                            ]);
                            foreach ($meta['cart']['items'] as $item) {
                                $order->items()->create([
                                    'product_id' => $item['product']['id'],
                                    'quantity' => $item['quantity'],
                                    'price' => $item['product']['price'],
                                ]);
                            }
                            $order->activities()->create([
                                'type' => 'Order Created',
                                'message' => 'Your order was placed successfully',
                            ]);
                            $sale = $order->sale()->create([
                                'code' => Sale::getCode(),
                                'customer_name' => $order['name'],
                                'customer_email' => $order['email'],
                                'customer_phone' => $order['phone'],
                                'customer_address' => $order['address'],
                                'date' => now()->format('Y-m-d'),
                                'note' => $order['note'],
                                'type' => 'online',
                                'shipping_fee' => $order['shipping']
                            ]);

                            foreach ($order->items()->with('product')->get() as $item) {
                                $sale->items()->create([
                                    'product_id' => $item['product']['id'],
                                    'quantity' => $item['quantity'],
                                    'price' => $item['price'],
                                    'profit' => $item['product']->getProfit()
                                ]);
                            }

                            CartController::clearUserCart();
                            $payment->update([
                                'order_id' => $order['id'],
                                'status' => 'successful'
                            ]);
                            NotificationController::sendOrderSuccessNotification($order);
                            return redirect()->route('orderSuccessful', $order)->with('success', 'Your payment was successful');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // return $e;
            $payment->update(['status' => 'failed']);
            return redirect('/checkout')->with('error', 'Payment not successful');
        }
        $payment->update(['status' => 'failed']);
        return redirect('/checkout')->with('error', 'Payment not successful');
    }
}
