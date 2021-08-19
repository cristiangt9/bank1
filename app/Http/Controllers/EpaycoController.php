<?php

namespace App\Http\Controllers;


class EpaycoController extends Controller
{
    private $url_apify = "https://apify.epayco.co";

    public function login()
    {
        $curl = curl_init();
        $http_headers = "Authorization: Basic YzgwODE5YjA0MjAzYjg0NGYxMTBlZWVkMDE2YmYwYzk6Mjk3NjQzYWYzZWMwM2RlNTZlOTQ5ZmJjYWFlYzFhY2E=";
        curl_setopt_array($curl, [
            CURLOPT_URL => "$this->url_apify/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                $http_headers
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $token = json_decode(
            $response, true);
        dd($token);
    }

    public function index()
    {
        # code...
    }
}
