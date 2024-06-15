<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Cuaca di {{ $weather['name'] }}</h1>
            <p class="text-lg">Suhu: {{ $weather['main']['temp'] }} °C</p>
            <p class="text-lg">Deskripsi: {{ $weather['weather'][0]['description'] }}</p>
            <p class="text-lg">Kelembaban: {{ $weather['main']['humidity'] }} %</p>
            <p class="text-lg">Kecepatan Angin: {{ $weather['wind']['speed'] }} m/s</p>
        </div>
    </div>
</body>
</html>
