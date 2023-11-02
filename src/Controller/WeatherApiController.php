<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('countryCode')] string $countryCode,
        #[MapQueryParameter('city')] string $city,
    ): JsonResponse
    {
        $forcasts = $util->getWeatherForCountryAndCity($countryCode, $city);
        $forcasts = array_map(function($forcast) {
            return [
                'date' => $forcast->getDate()->format('Y-m-d'),
                'temperature' => $forcast->getTemperature(),
                'feelsLikeTemp' => $forcast->getFeelsLikeTemp(),
                'humidity' => $forcast->getHumidity(),
                'windSpeed' => $forcast->getWindSpeed(),
            ];
        }, $forcasts);

        return $this->json([
            'city' => $city,
            'countryCode' => $countryCode,
            'forcasts' => $forcasts,
        ]);
    }
}
