<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyAPIService
{
    private $api_url;
    private $api_key;

    public function __construct()
    {
        $this->api_url = getenv("AMDOREN_API_URL");
        $this->api_key = getenv("AMDOREN_API_KEY");
    }

    public function validateSecretKey()
    {
        if (!$this->api_key) {
            throw new Exception("Not able to find secret key to connect to AMDOREN" . $this->api_key, 400);
        }

        return true;
    }

    public function getCurrencyList()
    {
        $this->validateSecretKey();

        $cache_currencies = [];
        if (Cache::has('currency_list')) {
            $cache_currencies = Cache::get('currency_list');
        } else {
            $response = Http::get(
                $this->api_url . '/currency_list.php',
                [
                    'api_key' => $this->api_key
                ]
            );

            if ($response->failed()) {
                throw new Exception("Connection to the API failed", 400);
            }

            $currencies = $response->json()['currencies'];

            $cache_currencies = Cache::remember(
                'currency_list',
                3600 * 24,
                function () use ($currencies) {
                    return $currencies;
                }
            );


            return $currencies;
        }

        return $cache_currencies;
    }
}
