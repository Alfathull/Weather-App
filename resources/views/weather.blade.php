<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-slate-950">
    <div class="relative">
        <img class="w-full h-[200px] opacity-75" src="assets/img/cloud.jpg" alt="Gambar Awan">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-950 "></div>
        <p class="text-3xl text-white font-bold absolute top-20 left-0 right-0 text-center p-4">Cuaca</p>
    </div>
    <div class="container mx-auto px-4">
        <div class="bg-slate-800 text-white p-6 rounded-lg shadow-lg">
            <div class="flex">
              <img src="https://img.icons8.com/?size=100&id=7880&format=png&color=ffffff" class="w-[25px] h-[25px] pt-1 mx-2">
              <h1 class="text-xl font-bold ">{{ $weather['name'] }}, {{ $weather['sys']['country'] }}</h1>
            </div>
            <div class="mt-1">
                @foreach($weather['weather'] as $w)
                    <div class="p-2 flex justify-between rounded">
                        <div class="flex">
                          <p class="text-4xl my-auto">{{ $weather['main']['temp'] }}°</p>
                        </div>
                        <div>
                          <img src="http://openweathermap.org/img/wn/{{ $w['icon'] }}.png" alt="{{ $w['description'] }}" class="w-[100px]">
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="text-lg text-bold p-2">{{ ucfirst($weather['weather'][0]['description']) }}</p>
            <div class="grid grid-cols-2 gap-1">
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Terasa Seperti</strong>
                <p>{{ $weather['main']['feels_like'] }}°</p>
              </div>
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Kelembaban</strong>
                <p>{{ $weather['main']['humidity'] }} %</p>
              </div>
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Tekanan</strong> 
                <p>{{ $weather['main']['pressure'] }} hPa</p>
              </div>
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Angin</strong>
                <p>{{ $weather['wind']['speed'] }} m/s</p>
              </div>
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Arah:</strong>
                <p>{{ $weather['wind']['deg'] }}°</p>
              </div>
              <div class="text-md bg-slate-600 rounded-lg shadow-lg p-2"><strong>Awan:</strong>
                <p>{{ $weather['clouds']['all'] }}%</p>
              </div>
            </div>

            {{-- <div class="mt-4">
                @if(isset($weather['wind']['gust']))
                    <p class="text-md"><strong>Gust:</strong> {{ $weather['wind']['gust'] }} m/s</p>
                @endif
            </div> --}}

            @if(isset($weather['rain']))
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Hujan:</h3>
                    <p class="text-md"><strong>1h:</strong> {{ $weather['rain']['1h'] }} mm</p>
                    @if(isset($weather['rain']['3h']))
                        <p class="text-md"><strong>3h:</strong> {{ $weather['rain']['3h'] }} mm</p>
                    @endif
                </div>
            @endif

            @if(isset($weather['snow']))
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Salju:</h3>
                    <p class="text-md"><strong>1h:</strong> {{ $weather['snow']['1h'] }} mm</p>
                    @if(isset($weather['snow']['3h']))
                        <p class="text-md"><strong>3h:</strong> {{ $weather['snow']['3h'] }} mm</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Ramalan Per 3 Jam di Hari Ini -->
<div class="bg-slate-800 text-white p-6 rounded-lg shadow-lg mt-8">
    <h2 class="text-2xl font-bold mb-4">Ramalan Cuaca Hari Ini</h2>
    <div class="space-y-4">
        @foreach($forecast['list'] as $weather)
            <!-- Cek apakah waktu ramalan berada di hari ini -->
            @if(strtotime($weather['dt_txt']) >= strtotime('today') && strtotime($weather['dt_txt']) <= strtotime('tomorrow'))
                <div class="p-4 bg-slate-600 rounded shadow">
                    <p class="text-lg font-semibold">{{ date('H:i', strtotime($weather['dt_txt'])) }}</p>
                    <p class="text-lg">Suhu: {{ $weather['main']['temp'] }} °C</p>
                    <p class="text-lg">Kecepatan Angin: {{ $weather['wind']['speed'] }} m/s</p>
                    <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="{{ $weather['weather'][0]['description'] }}">
                </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Prakiraan Harian -->
<div class="bg-slate-800 text-white p-6 rounded-lg shadow-lg mt-8">
    <h2 class="text-2xl font-bold mb-4">Prakiraan Cuaca 5 Hari</h2>
    <div class="space-y-4">
        @php
            $dates = [];
        @endphp
        @foreach($forecast['list'] as $weather)
            <!-- Ambil hanya satu prakiraan untuk setiap tanggal pada pukul 12:00 -->
            @php
                $date = date('Y-m-d', strtotime($weather['dt_txt']));
                $time = date('H:i', strtotime($weather['dt_txt']));
            @endphp
            @if($time == '12:00' && !in_array($date, $dates))
                <div class="p-4 bg-slate-600 rounded shadow">
                    <p class="text-lg font-semibold">{{ date('l, d M Y', strtotime($weather['dt_txt'])) }}</p>
                    <p class="text-lg">Suhu: {{ $weather['main']['temp'] }} °C</p>
                    <p class="text-lg">Kecepatan Angin: {{ $weather['wind']['speed'] }} m/s</p>
                    <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="{{ $weather['weather'][0]['description'] }}">
                </div>
                @php
                    $dates[] = $date;
                @endphp
            @endif
        @endforeach
    </div>
</div>




        <!-- Weather Map Section -->
        <div class="bg-slate-800 text-white p-6 rounded-lg shadow-lg mt-8">
            <h2 class="text-2xl font-bold mb-4">Peta Cuaca</h2>
            <div id="map" style="height: 500px;"></div>
        </div>
    </div>

    <script>
        // Initialize the map
        var map = L.map('map').setView([{{ $lat }}, {{ $lon }}], 8);

        // Set up the OSM layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Add weather layers
        var apiKey = '{{ $apiKey }}';
        var precipitationLayer = L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${apiKey}`).addTo(map);
        var cloudsLayer = L.tileLayer(`https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=${apiKey}`).addTo(map);
        var pressureLayer = L.tileLayer(`https://tile.openweathermap.org/map/pressure_new/{z}/{x}/{y}.png?appid=${apiKey}`).addTo(map);
        var windLayer = L.tileLayer(`https://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png?appid=${apiKey}`).addTo(map);
        var tempLayer = L.tileLayer(`https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=${apiKey}`).addTo(map);

        // Add layer control
        var baseMaps = {
            "Precipitation": precipitationLayer,
            "Clouds": cloudsLayer,
            "Pressure": pressureLayer,
            "Wind": windLayer,
            "Temperature": tempLayer
        };

        L.control.layers(baseMaps).addTo(map);
    </script>
</body>
</html>
