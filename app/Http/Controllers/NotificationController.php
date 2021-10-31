<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifications\OrderNotification;
use App\Notifications\CustomNotificationByEmail;
use App\Notifications\CustomNotificationByStaticEmail;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public static function sendOrderSuccessNotification($order)
    {
        $orderDetails = '<h3>Order Summary</h3><table style="border-collapse: collapse; width: 100%; margin: 25px 0; font-family: sans-serif; min-width: 400px;">';
        foreach ($order->items()->get() as $orderDetail) {
            $orderDetails .= '<tr style="border-bottom: thin solid #dddddd; width: 100%">
                                   <td style="padding: 20px 15px;"><img src="'.asset($orderDetail->product->image).'" width="80" alt=""></td>
                                   <td style="padding: 20px 15px;">'.$orderDetail->product->name.' x '.$orderDetail->quantity.'</td>
                                   <td style="padding: 20px 15px;">₦'.number_format(($orderDetail->price * $orderDetail->quantity), 2).'</td>
                              </tr>';
        }
        if ($order['additional_fee']) $orderDetails .= '<tr style="width: 100%"><td colspan="2" style="padding: 20px 15px;"><b>Additional Fee</b></td><td style="padding: 12px 15px;"> ₦'.number_format($order['additional_fee'], 2).'</td></tr>';
        if ($order['shipping']) $orderDetails .= '<tr style="width: 100%"><td colspan="2" style="padding: 20px 15px;"><b>Delivery Fee</b></td><td style="padding: 12px 15px;"> ₦'.number_format($order['shipping'], 2).'</td></tr>';
        $orderDetails .= '<tr style="width: 100%"><td colspan="2" style="padding: 20px 15px;"><b>Total</b></td><td style="padding: 12px 15px;">₦'.number_format($order['total'], 2).'</td></tr></table>';

        $buyerData = [
            'subject' => 'Order #' . $order['code'] . ' Confirmed',
            'content' => 'Your order was successful, your order ID is '.$order['code'].'. We are getting your order ready to be delivered. We will notify you when it has been sent.',
            'order' => $order,
            'order_details' => $orderDetails,
            'button_label' => 'Track Order',
            'button_href' => route('orderTracking'),
            'additional_text' => 'Thanks for your patronage!'
        ];
        if ($order['email']) Notification::route('mail', $order['email'])->notify(new OrderNotification($buyerData));

        $vendorData = [
            'subject' => 'New Order #'.$order['code'].' Placed',
            'content' => 'An order with ID '.$order['code'].' was successfully. Order details listed below, Login now to process the order.',
            'order' => $order,
            'order_details' => $orderDetails,
            'button_label' => 'View Order',
            'button_href' => route('admin.orders.show', $order),
            'additional_text' => null
        ];

        if (env('ADMIN_EMAIL'))
            Notification::route('mail', env('ADMIN_EMAIL'))->notify(new OrderNotification($vendorData));
    }


    public static function sendInvoiceLinkNotification($email, $link)
    {
        $msg = 'An invoice has been generated for your transaction with '.env('APP_NAME').'.<br>
                Click on the button below to download your invoice.';
        if ($email)
            Notification::route('mail', $email)->notify(new CustomNotificationByStaticEmail('Transaction Invoice', $msg, 'Download Invoice', $link));
    }

    public static function sendOrderActivityNotification($order, $activity)
    {
        Notification::route('mail', $order['email'])->notify(new CustomNotificationByStaticEmail('Order #'.$order['code'].' '.$activity['type'], $activity['message'], 'Track Order', route('orderTracking')));
    }
}
