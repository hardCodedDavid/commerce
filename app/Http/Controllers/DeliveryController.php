<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public static function estimateDelivery($dropoffs)
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://private-anon-8d29497fae-gokada2.apiary-mock.com/api/developer/v3/order_estimate', [
//            ->post('https://api.gokada.ng/api/developer/v3/order_estimate', [
                "api_key" => env('GOKADA_API_KEY'),
                "pickup_address" => env('GOKADA_PICKUP_ADDRESS'),
                "pickup_latitude" => env('GOKADA_PICKUP_LATITUDE'),
                "pickup_longitude" => env('GOKADA_PICKUP_LONGITUDE'),
                "dropoffs" => $dropoffs
            ]);
    }

    public static function createDelivery($data)
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://private-anon-8d29497fae-gokada2.apiary-mock.com/api/developer/v3/order_create', [
                "api_key" => env('GOKADA_API_KEY'),
                "pickup_address" => $data['address'],
                "pickup_latitude" => $data['latitude'],
                "pickup_longitude" => $data['longitude'],
                "pickup_customer_name" => $data['longitude'],
                "pickup_customer_email" => $data['longitude'],
                "pickup_customer_phone" => $data['phone'],
                "pickup_datetime" => $data['date'],
                "dropoffs" => $data['dropoffs']
            ]);
    }

    public static function checkDeliveryStatus($id)
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://private-anon-8d29497fae-gokada2.apiary-mock.com/api/developer/v3/order_status', [
                "api_key" => env('GOKADA_API_KEY'),
                "order_id" => $id
            ]);
    }

    public static function cancelDelivery($id)
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://private-anon-8d29497fae-gokada2.apiary-mock.com/api/developer/v3/order_cancel', [
                "api_key" => env('GOKADA_API_KEY'),
                "order_id" => $id
            ]);
    }

    public function deliveryCallback()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $data = serialize($data);

        define('GOKADA_SECRET_KEY', env('GOKADA_API_KEY'));

        // Get signature from header and base64 decode it
        $header = $_SERVER['HTTP_X_GOKADA_SIGNATURE'];
        $signature = base64_decode($header);

        // Get the expected hash
        $hash = hash_hmac('sha1', $data, GOKADA_SECRET_KEY);

        // Verify signature is correct
        if($signature !== $hash) exit();

        try {
            //
        } catch (\Exception $e) {
            logger($e->getMessage());
            exit();
        }

        http_response_code(200);
        exit();
    }
}
