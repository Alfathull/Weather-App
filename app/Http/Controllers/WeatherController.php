<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function index()
    {
        $lat = -6.9175; // Latitude for Bandung
        $lon = 107.6191; // Longitude for Bandung
        // $lat = -33.8688; // Latitude for Sydney
        // $lon = 151.2093; // Longitude for Sydney
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

        // Menghitung waktu saat ini berdasarkan timezone offset yang dikembalikan oleh API
        $timezoneOffset = $weatherData['timezone'];
        $currentDateTime = Carbon::now()->utc()->addSeconds($timezoneOffset);

        return view('weather', [
            'weather' => $weatherData,
            'forecast' => $forecastData,
            'apiKey' => $apiKey,
            'timezone' => $weatherData['timezone'],
            'lat' => $lat, // Menambahkan variabel $lat
            'lon' => $lon, // Menambahkan variabel $lon
            'currentDateTime' => $currentDateTime // Menambahkan variabel waktu saat ini
        ]);
    }
}
