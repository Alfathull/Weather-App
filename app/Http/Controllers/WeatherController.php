<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $lat = '44.34'; // contoh latitude
        $lon = '10.99'; // contoh longitude
        $apiKey = 'b0a5d152b99da8f75e139c8a7de577ae';

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        $weatherData = $response->json();

        return view('weather', ['weather' => $weatherData]);
    }
}
