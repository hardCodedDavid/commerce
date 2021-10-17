<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class DeliveryController extends Controller
{
    public static $token;

    public function __construct()
    {
        self::$token = 'Bearer '. env('CNS_ACCESS_TOKEN');
    }

    public function getStates()
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/States'), true);
    }

    public function getCities()
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/operations/cities'), true);
    }

    /**
     * @throws ValidationException
     */
    public function getCitiesByState()
    {
        $this->validate(request(), ['state' => 'required']);
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/StateCities?StateName='.request('state')), true);
    }

    /**
     * @throws ValidationException
     */
    public function getDeliveryTowns()
    {
        $this->validate(request(), ['city_code' => 'required']);
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/DeliveryTowns?CityCode='.request('city_code')), true);
    }

    /**
     * @throws ValidationException
     */
    public function getDropOffLocations()
    {
        $this->validate(request(), ['city_code' => 'required']);
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/ClicknShip/Operations/DropOffAddresses?citycode='.request('city_code')), true);
    }

    public function estimateDeliveryFee()
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->post('https://api.clicknship.com.ng/clicknship/Operations/DeliveryFee', [
                'Origin' => env('CNS_ORIGIN'),
                'Destination' => 'LAGOS MAINLAND',
                'OnforwardingTownID' => '17',
                'Weight' => '1.5',
                'PickupType' => '1'
            ]), true);
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

    public static function getToken()
    {
        $data = json_decode(Http::withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->asForm()->post('https://api.clicknship.com.ng/Token', [
                'username' => env('CNS_USERNAME'),
                'password' => env('CNS_PASSWORD'),
                'grant_type' => 'password'
            ]), true);

        if (isset($data['access_token'])) {
            file_put_contents(App::environmentFilePath(), str_replace(
                'CNS_ACCESS_TOKEN' . '=' . env('CNS_ACCESS_TOKEN'),
                'CNS_ACCESS_TOKEN' . '=' . $data['access_token'],
                file_get_contents(App::environmentFilePath())
            ));
            file_put_contents(App::environmentFilePath(), str_replace(
                'CNS_TOKEN_EXPIRY' . '=' . env('CNS_TOKEN_EXPIRY'),
                'CNS_TOKEN_EXPIRY' . '=' . $data['expires_in'],
                file_get_contents(App::environmentFilePath())
            ));

            // Reload the cached config
            if (file_exists(App::getCachedConfigPath())) {
                Artisan::call("config:cache");
            }
        }
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
        } catch (Exception $e) {
            logger($e->getMessage());
            exit();
        }

        http_response_code(200);
        exit();
    }
}
