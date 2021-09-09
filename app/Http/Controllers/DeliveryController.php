<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public static function estimateDelivery($data)
    {
        return Http::withHeaders(['Content-Type' => 'application/json'])->post('https://private-anon-8d29497fae-gokada2.apiary-mock.com/api/developer/v3/order_estimate', [
            "api_key" => env('GOKADA_API_KEY'),
            "pickup_address" => $data['pickup_address'],
            "pickup_latitude" => $data['pickup_latitude'],
            "pickup_longitude" => $data['pickup_longitude'],
            "dropoffs" => $data['dropoffs']
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
