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

        // Mengambil data cuaca saat ini
        $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        $weatherData = $weatherResponse->json();

        // Mengambil data prakiraan cuaca 5 hari
        $forecastResponse = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        $forecastData = $forecastResponse->json();

        return view('weather', [
            'weather' => $weatherData,
            'forecast' => $forecastData,
            'apiKey' => $apiKey,
            'lat' => $lat, // Menambahkan variabel $lat
            'lon' => $lon  // Menambahkan variabel $lon
        ]);
    }
}
