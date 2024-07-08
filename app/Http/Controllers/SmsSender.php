<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsSender extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }
    public function sendSms($to,$text){


      $apiURL = env('SMS_API_URL');

      // POST Data
      $postInput = [
        'accountid' => env("SMS_ACCOUNT_ID"),
        'password' => env('SMS_PASSWORD'),
        'to' => $to,
        'text' => $text,
        'sender' => env('SMS_SENDER'),

      ];

      // Headers
      $headers = [
        'Content-Type'=> 'application/xml',
        'Cookie'=> 'SIV50=e0bej601tc4g8gtpc8nv1ajud7',
      ];

      $response = Http::withHeaders($headers)->post($apiURL, $postInput);

      $statusCode = $response->status();
     return $responseBody = json_decode($response->getBody(), true);

    }
}
