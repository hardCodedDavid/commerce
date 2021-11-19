<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public static string $token;

    public function __construct()
    {
        self::$token = 'Bearer '. env('CNS_ACCESS_TOKEN');
    }

    public function getStates()
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/States'), true);
    }

    public function getCitiesByState($state)
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/StateCities?StateName='.$state), true);
    }

    public function getDeliveryTowns($city)
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/DeliveryTowns?CityCode='.$city), true);
    }

    public function getDropOffLocations($city)
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/ClicknShip/Operations/DropOffAddresses?citycode='.$city), true);
    }

    public function estimateDeliveryFee($destination, $townID, $weight)
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->post('https://api.clicknship.com.ng/clicknship/Operations/DeliveryFee', [
                'Origin' => env('CNS_CITY'),
                'Destination' => $destination,
                'OnforwardingTownID' => $townID,
                'Weight' => $weight,
                'PickupType' => '1'
            ]), true);
    }

    public function trackShipment($waybill)
    {
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->get('https://api.clicknship.com.ng/clicknship/Operations/TrackShipment?waybillno='.$waybill), true);
    }

    public function pickupRequest($code, $data)
    {
        $data['OrderNo'] = $code;
        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
            ->post('https://api.clicknship.com.ng/clicknship/Operations/PickupRequest', $data), true);
    }

//    public function printWaybill($waybill)
//    {
//        return Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
//            ->get('https://api.clicknship.com.ng/clicknship/Operations/PrintWaybill?waybillno='.$waybill);
//    }

    public static function getToken()
    {
        $data = json_decode(Http::withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->asForm()->post('https://api.clicknship.com.ng/Token', [
                'username' => env('CNS_USERNAME'),
                'password' => env('CNS_PASSWORD'),
                'grant_type' => 'password'
            ]), true);

        logger($data);
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

//    public function getCities()
//    {
//        return json_decode(Http::withHeaders(['Content-Type' => 'application/json', 'Authorization' => self::$token])
//            ->get('https://api.clicknship.com.ng/clicknship/operations/cities'), true);
//    }
}
