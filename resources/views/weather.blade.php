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
        <img class="w-full h-[200px] md:h-[250px] xl:h-[300px] opacity-75" src="{{ asset('assets/img/cloud.jpg') }}" alt="Cloud Image">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-950 "></div>
        <p class="text-3xl text-white font-bold absolute top-20 xl:top-28 left-0 right-0 text-center p-4">Cuaca</p>
    </div>
    <div class="container mx-auto px-4">
        <div class="bg-slate-800 text-white p-6 rounded-2xl shadow-2xl">
            <div class="flex">
              <img src="https://img.icons8.com/?size=100&id=7880&format=png&color=ffffff" class="w-[25px] h-[25px] pt-1 mx-2" alt="Icon Location">
              <h1 class="text-xl font-bold ">{{ $weather['name'] }}, {{ $weather['sys']['country'] }}</h1>
            </div>
            <div class="text-md text-slate-400 mx-2">
                @php
                    // Set the locale to Indonesian
                    \Carbon\Carbon::setLocale('id');
                @endphp
                {{ $currentDateTime->translatedFormat('l, d F Y H:i') }}
            </div>
            <div class="mt-1">
                @foreach($weather['weather'] as $w)
                    <div class="p-2 flex justify-between rounded">
                        <div class="flex">
                          <p class="text-4xl my-auto text-bold">{{ $weather['main']['temp'] }}°</p>
                        </div>
                        <div>
                          <img src="http://openweathermap.org/img/wn/{{ $w['icon'] }}.png" alt="{{ $w['description'] }}" class="w-[100px] h-[100px] mx-auto animate-bounce">
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="text-lg text-bold p-2">{{ ucfirst($weather['weather'][0]['description']) }}</p>
            <div class="grid grid-cols-2 gap-1 text-slate-400">
              <div class="text-md bg-slate-600  rounded-2xl shadow-2xl py-2 px-4">Terasa Seperti
                <p class="text-white text-bold text-xl">{{ $weather['main']['feels_like'] }}°</p>
              </div>
              <div class="text-md bg-slate-600 rounded-2xl shadow-2xl py-2 px-4">Kelembaban
                <p class="text-white text-bold text-xl">{{ $weather['main']['humidity'] }} %</p>
              </div>
              <div class="text-md bg-slate-600 rounded-2xl shadow-2xl py-2 px-4">Tekanan 
                <p class="text-white text-bold text-xl">{{ $weather['main']['pressure'] }} hPa</p>
              </div>
              <div class="text-md bg-slate-600 rounded-2xl shadow-2xl py-2 px-4">Angin
                <p class="text-white text-bold text-xl">{{ $weather['wind']['speed'] }} m/s</p>
              </div>
              <div class="text-md bg-slate-600 rounded-2xl shadow-2xl py-2 px-4">Arah:
                <p class="text-white text-bold text-xl">{{ $weather['wind']['deg'] }}°</p>
              </div>
              <div class="text-md bg-slate-600 rounded-2xl shadow-2xl py-2 px-4">Awan:
                <p class="text-white text-bold text-xl">{{ $weather['clouds']['all'] }}%</p>
              </div>
            </div>
        </div>

        <!-- Ramalan Per 3 Jam di Hari Ini -->
        <div class="bg-slate-800 text-white p-6 rounded-2xl shadow-2xl mt-3">
            <h2 class="text-2xl font-bold mb-4">Cuaca Hari Ini</h2>
            <div class="space-y-2" id="forecast-today">
                <!-- Forecast items will be populated by JavaScript -->
            </div>
            <div class="flex justify-center">
                <button id="show-more" class="mt-4 p-2 bg-gray-700 text-white text-bold rounded-xl px-8 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-gray-600 duration-300">Lainnya</button>
            </div>
        </div>

        <!-- Prakiraan Harian -->
        <div class="bg-slate-800 text-white p-6 rounded-lg shadow-lg mt-3">
            <h2 class="text-2xl font-bold mb-4">Cuaca 5 Hari</h2>
            <div class="space-y-2">
                @php
                    $dates = [];
                    $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                    $months = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
                @endphp
                @foreach($forecast['list'] as $weather)
                    @php
                        $date = date('Y-m-d', strtotime($weather['dt_txt']));
                        $time = date('H:i', strtotime($weather['dt_txt']));
                        $day = $days[date('l', strtotime($weather['dt_txt']))];
                        $month = $months[date('F', strtotime($weather['dt_txt']))];
                        $formattedDate = $day . ', ' . date('d', strtotime($weather['dt_txt'])) . ' ' . $month . ' ' . date('Y', strtotime($weather['dt_txt']));
                    @endphp
                    @if($time == '12:00' && !in_array($date, $dates))
                        <div class="px-4 py-2 bg-slate-600 rounded shadow grid grid-cols-4">
                            <p class="text-lg font-semibold text-center my-auto">{{ $day }}</p>
                            <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="{{ $weather['weather'][0]['description'] }}" class="mx-auto">
                            <p class="text-lg text-center my-auto">{{ $weather['main']['temp'] }}°</p>
                            <p class="text-lg text-center my-auto">{{ $weather['wind']['speed'] }} m/s</p>
                        </div>
                        @php
                            $dates[] = $date;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Weather Map Section -->
        <div class="bg-slate-800 text-white p-6 rounded-2xl shadow-2xl mt-3">
            <h2 class="text-2xl font-bold mb-4">Peta Cuaca</h2>
            <div id="map" style="height: 500px;"></div>
        </div>

        
    </div>
    
    <footer class=" shadow bg-slate-800 mt-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <span class="block text-sm text-center text-gray-400">© 2024 <a href="/" class="hover:underline">Weather-App</a>. All Rights Reserved.</span>
        </div>
    </footer>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forecastToday = @json($forecast['list']);
            const timezoneOffset = {{ $timezone }}; // timezone offset in seconds
            const currentDate = new Date();
            const currentUTCDate = new Date(currentDate.getTime() + currentDate.getTimezoneOffset() * 60000);
            const localDate = new Date(currentUTCDate.getTime() + timezoneOffset * 1000);
            const localTime = localDate.getHours() * 100 + localDate.getMinutes();
            const container = document.getElementById('forecast-today');
            const showMoreButton = document.getElementById('show-more');
            let limit = 3;

            function renderForecast(limit) {
                container.innerHTML = '';
                let count = 0;
                for (const weather of forecastToday) {
                    const forecastDate = new Date(weather.dt_txt);
                    const forecastLocalDate = new Date(forecastDate.getTime() + timezoneOffset * 1000);
                    const forecastLocalTime = forecastLocalDate.getHours() * 100 + forecastLocalDate.getMinutes();

                    if (forecastDate.toDateString() === localDate.toDateString() && forecastLocalTime >= localTime) {
                        if (count < limit) {
                            const forecastItem = `
                                <div class="px-4 py-2 bg-slate-600 rounded shadow grid grid-cols-4">
                                    <p class="text-lg font-semibold text-center my-auto">${forecastLocalDate.getHours()}:00</p>
                                    <img src="http://openweathermap.org/img/wn/${weather.weather[0].icon}.png" alt="${weather.weather[0].description}" class="mx-auto">
                                    <p class="text-lg text-center my-auto">${weather.main.temp}°</p>
                                    <p class="text-lg text-center my-auto">${weather.wind.speed} m/s</p>
                                </div>
                            `;
                            container.innerHTML += forecastItem;
                            count++;
                        }
                    }
                }
            }

            renderForecast(limit);

            showMoreButton.addEventListener('click', function() {
                renderForecast(forecastToday.length);
                showMoreButton.style.display = 'none';
            });
        });
    </script>
</body>
</html>
