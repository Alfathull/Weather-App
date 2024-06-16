# Weather App

This is a sophisticated weather application built with Laravel and Tailwind CSS, designed to provide users with accurate and up-to-date weather information by interfacing with the OpenWeatherMap API. The application is responsive, ensuring optimal display on both desktop and mobile devices.

## Key Features

- **Real-Time Weather Data**: Utilizes the OpenWeatherMap API to fetch current weather conditions, including temperature, humidity, wind speed, and atmospheric pressure.
- **5-Day Weather Forecast**: Displays a comprehensive 5-day weather forecast that updates dynamically based on data retrieved from the OpenWeatherMap API.
- **Interactive Weather Maps**: Integrates Leaflet.js for interactive mapping, showing different weather layers such as precipitation, clouds, and temperature, pulled from OpenWeatherMap's tiled weather maps.
- **Responsive Design**: Built with Tailwind CSS, ensuring the application is fully responsive and functional across all devices and screen sizes.

## Technical Implementation

### API Integration

- **Current and Forecast Weather Data**: Makes HTTP GET requests to the OpenWeatherMap API endpoints to retrieve current weather data and a 5-day forecast. This data is then parsed and displayed in various components of the application.
- **Weather Map Layers**: Uses OpenWeatherMap's layered maps to display real-time weather phenomena by overlaying data on an interactive Leaflet.js map.

### Frontend Design

- **Tailwind CSS**: Utilizes Tailwind CSS for styling, taking advantage of its utility-first classes to create a modular and easily maintainable stylesheet.
- **Responsive Layouts**: Implements flexible grid and flex layouts to ensure the application is accessible and usable on a wide range of devices.

## Prerequisites

Before you begin, ensure you have the following installed on your system:
- PHP (>= 7.3)
- Composer
- Node.js and npm

## Installation

Follow these steps to get your development environment running:

1. **Clone the repository**

   ```bash
   git clone https://github.com/Alfathull/Weather-App.git
   cd Weather-App
   ```
2. **Install PHP dependencies**

    ```bash
    composer install
    Copy the environment file
    ```

3. **Copy the environment file**

    ```bash
    cp .env.example .env
    ```

4. **Generate an application key**

    ```bash
    php artisan key:generate
    ```

5. **Install JavaScript dependencies**

    ```bash
    npm instal
    ```

6. **Compile assets**

    ```bash
    npm run dev
    ```

7. **Start the Laravel server**

    ```bash
    php artisan serve
    ```
This will start the Laravel development server at http://localhost:8000.

## Usage
Navigate to http://localhost:8000 to access real-time weather updates and forecasts. Use the interactive map to view specific weather layers based on your preferences.

## Contributing
Contributions to improve the app are welcome. Feel free to fork the repository and submit pull requests.

## License
This project is open-source under the MIT License.

```css
This README provides a clear, detailed overview of how your application works, particularly how it interacts with an external API, and demonstrates your ability to integrate various technologies to create a functional and user-friendly product. It’s tailored to impress potential employers by highlighting your technical skills and understanding of modern web technologies.
```
