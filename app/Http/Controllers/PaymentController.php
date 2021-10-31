<?php

namespace App\Http\Controllers;

use App\Models\ItemNumber;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Illuminate\Http\RedirectResponse;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PaymentController extends Controller
{
    public static function initializeTransaction($data): RedirectResponse
    {
        $reference = Flutterwave::generateReference();

        $paymentData = [
            'payment_options' => 'card,banktransfer',
            'amount' => $data['amount'],
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

        Payment::create([
            'user_id' => auth()->user()['id'] ?? null,
            'reference' => $reference,
            'amount' => $data['amount'],
            'meta' => json_encode($data)
        ]);

        $payment = Flutterwave::initializePayment($paymentData);


        if ($payment['status'] !== 'success')
            return back()->with('error', 'Could not checkout, try again.')->withInput();

        return redirect($payment['data']['link']);
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
                        $order = self::finishOrder(null, $payment);
                        $payment->update([
                            'order_id' => $order['id'],
                            'status' => 'successful'
                        ]);
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
    }

    public static function finishOrder($meta = null, $payment = null)
    {
        $meta = $meta ?? json_decode($payment['meta'], true);
        $method = $meta['delivery_method'];
        if ($method == 'pickup')
            $order = Order::create([
                'payment_id' => $payment['id'] ?? null,
                'user_id' => $meta['auth'] == true ? $meta['user_id'] : null,
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
                'payment_id' => $payment['id'] ?? null,
                'user_id' => $meta['auth'] == true ? $meta['user_id'] : null,
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
                'additional_fee' => $meta['additional_fee'],
                'payment_type' => $meta['payment_type'],
                'total' => $meta['amount'],
                'CNS' => json_encode($meta['CNS'])
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
                $order->items()->create([
                    'product_id' => $item['product']['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->getDiscountedPrice(),
                    'item_numbers' => json_encode($numbers)
                ]);

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
                    'shipping_fee' => $order['shipping'],
                    'additional_fee' => $order['additional_fee']
                ]);

                foreach ($order->items()->with('product')->get() as $orderItem) {
                    $saleItem = $sale->items()->create([
                        'product_id' => $orderItem['product']['id'],
                        'quantity' => $orderItem['quantity'],
                        'price' => $orderItem['price'],
                        'profit' => $orderItem['product']->getProfit() * $orderItem['quantity'],
                        'item_numbers' => $orderItem['item_numbers']
                    ]);

                    foreach (json_decode($orderItem['item_numbers'] ?? '', true) as $itemNumber) {
                        $number = ItemNumber::find(array_keys($itemNumber)[0]);
                        if ($number)
                            $number->update(['sale_item_id' => $saleItem['id']]);
                    }
                }
            }
        }
        CartController::clearUserCart();
        NotificationController::sendOrderSuccessNotification($order);
        return $order;
    }
}
