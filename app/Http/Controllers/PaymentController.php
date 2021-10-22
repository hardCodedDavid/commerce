<?php

namespace App\Http\Controllers;

use App\Models\ItemNumber;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\RedirectResponse;
//use Unicodeveloper\Paystack\Facades\Paystack;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PaymentController extends Controller
{
    public static function initializeTransaction($amount, $data): RedirectResponse
    {
        $reference = Flutterwave::generateReference();

        $paymentData = [
            'payment_options' => 'card,banktransfer',
            'amount' => $amount,
            'email' => $data['email'],
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('payment.callback'),
            'customer' => [
                'email' => $data['email'],
                "phone_number" => $data['phone'],
                "name" => $data['name']
            ],

            "customizations" => [
                "title" => 'Marksot Checkout',
                "description" => date('d M, Y')
            ]
        ];

        $data['amount'] = $amount;
        Payment::create([
            'user_id' => auth()->user()['id'] ?? null,
            'reference' => $reference,
            'amount' => $amount,
            'meta' => json_encode($data)
        ]);

        $payment = Flutterwave::initializePayment($paymentData);


        if ($payment['status'] !== 'success')
            return back()->with('error', 'Could not checkout, try again.')->withInput();

        return redirect($payment['data']['link']);

//        $paymentData = [
//            'amount' => $amount * 100,
//            'reference' => Paystack::genTranxRef(),
//            'email' => $data['email'],
//            'currency' => 'NGN',
//            'metadata' => json_encode(collect($data))
//        ];
//        Payment::create([
//            'user_id' => auth()->user()['id'] ?? null,
//            'reference' => $paymentData['reference'],
//            'amount' => $amount,
//            'meta' => json_encode($data)
//        ]);
//        request()->merge($paymentData);
//        try{
//            return Paystack::getAuthorizationUrl()->redirectNow();
//        }catch(Exception $e) {
//            return back()->with('error', 'The paystack token has expired. Please refresh the page and try again.');
//        }
    }

    public function handlePaymentCallback()
    {
        $status = request('status');
        if ($status == 'successful') {
            $payment = Payment::query()->where('reference', request('tx_ref'))->first();
            try {
                $transactionID = Flutterwave::getTransactionIDFromCallback();
                $data = Flutterwave::verifyTransaction($transactionID);
                if ($data) {
                    $payment = Payment::query()->where('reference', $data['data']['tx_ref'])->first();
                    if ($payment && $payment['status'] == 'pending') {
                        $meta = json_decode($payment['meta'], true);
                        $method = $meta['delivery_method'];
                        if ($method == 'pickup')
                            $order = Order::create([
                                'payment_id' => $payment['id'],
                                'user_id' => auth()->user()['id'] ?? null,
                                'code' => Order::getCode(),
                                'name' => $meta['name'],
                                'email' => $meta['email'],
                                'phone' => $meta['phone'],
                                'delivery_method' => $method,
                                'pickup_location' => $meta['pickup_location'],
                                'pickup_date' => now()->addDays(5),
                                'total' => $meta['amount']
                            ]);
                        else
                            $order = Order::create([
                                'payment_id' => $payment['id'],
                                'user_id' => auth()->user()['id'] ?? null,
                                'code' => Order::getCode(),
                                'name' => $meta['name'],
                                'email' => $meta['email'],
                                'phone' => $meta['phone'],
                                'country' => $meta['country'],
                                'state' => $meta['state'],
                                'city' => $meta['city'],
                                'address' => $meta['address'],
                                'longitude' => $meta['longitude'],
                                'latitude' => $meta['latitude'],
                                'note' => $meta['note'],
                                'delivery_method' => $method,
                                'shipping' => $meta['delivery_fee'],
                                'total' => $meta['amount']
                            ]);
                        foreach ($meta['cart']['items'] as $item) {
                            $product = Product::find($item['product']['id']);
                            $numbers = [];
                            if ($product) {
                                $itemNumbers = $product->itemNumbers()->where('status', 'available')->get()->take($item['quantity']);
                                foreach ($itemNumbers as $itemNumber) {
                                    $numbers[] = [$itemNumber['id'] => $itemNumber['no']];
                                    $itemNumber->update(['status' => 'sold', 'date_sold' => now()]);
                                }
                            }
                            $order->items()->create([
                                'product_id' => $item['product']['id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['product']['price'],
                                'item_numbers' => json_encode($numbers)
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
                            $saleItem = $sale->items()->create([
                                'product_id' => $item['product']['id'],
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                                'profit' => $item['product']->getProfit() * $item['quantity'],
                                'item_numbers' => $item['item_numbers']
                            ]);

                            foreach (json_decode($item['item_numbers'] ?? '', true) as $itemNumber) {
                                $number = ItemNumber::find(array_keys($itemNumber)[0]);
                                if ($number)
                                    $number->update(['sale_item_id' => $saleItem['id']]);
                            }
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
            } catch (Exception $e) {
                logger($e);
                $payment->update(['status' => 'failed']);
                return redirect('/checkout')->with('error', 'Payment not successful');
            }
            $payment->update(['status' => 'failed']);
        }
        return redirect('/checkout')->with('error', 'Payment not successful');

//        $paymentDetails = Paystack::getPaymentData();
//        $res = $paymentDetails['data'];
//        $payment = Payment::query()->where('reference', $res['reference'])->first();
//        try {
//            if (isset($paymentDetails['status'])) {
//                if (isset($res)) {
//                    if ($res["status"] == 'success') {
//                        if ($payment && $payment['status'] == 'pending') {
//                            $meta = json_decode($payment['meta'], true);
//                            $method = $meta['delivery_method'];
//                            if ($method == 'pickup')
//                                $order = Order::create([
//                                    'user_id' => auth()->user()['id'] ?? null,
//                                    'code' => Order::getCode(),
//                                    'name' => $meta['name'],
//                                    'email' => $meta['email'],
//                                    'phone' => $meta['phone'],
//                                    'delivery_method' => $method,
//                                    'pickup_location' => $meta['pickup_location'],
//                                    'pickup_date' => now()->addDays(5),
//                                    'total' => $meta['cart']['total']
//                                ]);
//                            else
//                                $order = Order::create([
//                                    'user_id' => auth()->user()['id'] ?? null,
//                                    'code' => Order::getCode(),
//                                    'name' => $meta['name'],
//                                    'email' => $meta['email'],
//                                    'phone' => $meta['phone'],
//                                    'country' => $meta['country'],
//                                    'state' => $meta['state'],
//                                    'city' => $meta['city'],
//                                    'address' => $meta['address'],
//                                    'longitude' => $meta['longitude'],
//                                    'latitude' => $meta['latitude'],
//                                    'note' => $meta['note'],
//                                    'delivery_method' => $method,
//                                    'total' => $meta['cart']['total']
//                                ]);
//                            foreach ($meta['cart']['items'] as $item) {
//                                $order->items()->create([
//                                    'product_id' => $item['product']['id'],
//                                    'quantity' => $item['quantity'],
//                                    'price' => $item['product']['price'],
//                                ]);
//                            }
//                            $order->activities()->create([
//                                'type' => 'Order Created',
//                                'message' => 'Your order was placed successfully',
//                            ]);
//                            $sale = $order->sale()->create([
//                                'code' => Sale::getCode(),
//                                'customer_name' => $order['name'],
//                                'customer_email' => $order['email'],
//                                'customer_phone' => $order['phone'],
//                                'customer_address' => $order['address'],
//                                'date' => now()->format('Y-m-d'),
//                                'note' => $order['note'],
//                                'type' => 'online',
//                                'shipping_fee' => $order['shipping']
//                            ]);
//
//                            foreach ($order->items()->with('product')->get() as $item) {
//                                $sale->items()->create([
//                                    'product_id' => $item['product']['id'],
//                                    'quantity' => $item['quantity'],
//                                    'price' => $item['price'],
//                                    'profit' => $item['product']->getProfit()
//                                ]);
//                            }
//
//                            CartController::clearUserCart();
//                            $payment->update([
//                                'order_id' => $order['id'],
//                                'status' => 'successful'
//                            ]);
//                            NotificationController::sendOrderSuccessNotification($order);
//                            return redirect()->route('orderSuccessful', $order)->with('success', 'Your payment was successful');
//                        }
//                    }
//                }
//            }
//        } catch (Exception $e) {
//            logger($e);
//            // return $e;
//            $payment->update(['status' => 'failed']);
//            return redirect('/checkout')->with('error', 'Payment not successful');
//        }
//        $payment->update(['status' => 'failed']);
//        return redirect('/checkout')->with('error', 'Payment not successful');
    }
}
