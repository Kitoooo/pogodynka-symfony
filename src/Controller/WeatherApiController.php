<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('countryCode')] string $countryCode,
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $valid_formats = ['json', 'csv'];
        if (!in_array($format, $valid_formats)) {
            throw $this->createNotFoundException('Invalid format - must be one of [ '.implode(', ', $valid_formats).' ]');
        }
        $forcasts = $util->getWeatherForCountryAndCity($countryCode, $city);
        $forcasts = array_map(function($forcast) {
            return [
                'date' => $forcast->getDate()->format('Y-m-d'),
                'celsius' => $forcast->getTemperature(),
                'fahrenheit' => $forcast->getFahrenheit(),
                'feelsLikeTemp' => $forcast->getFeelsLikeTemp(),
                'humidity' => $forcast->getHumidity(),
                'windSpeed' => $forcast->getWindSpeed(),
            ];
        }, $forcasts);

        if ($twig){
            return $this->render('weather_api/index.'.$format.'.twig', [
                'city' => $city,
                'countryCode' => $countryCode,
                'forcasts' => $forcasts,
            ]);
        }

        if ($format === 'csv') {
            $response = new Response();
//            $response->headers->set('Content-Type', 'text/csv');
//            $response->headers->set('Content-Disposition', 'attachment; filename="weather.csv"');
            $csv = "city,countryCode,date,celsius,fahrenheit,feelsLikeTemp,humidity,windSpeed\n";
            $csv .= implode("\n",array_map(function($forcast) use ($city, $countryCode) {
                return sprintf(
                    '%s,%s,%s,%s,%s,%s,%s,%s',
                    $city,
                    $countryCode,
                    $forcast['date'],
                    $forcast['celsius'],
                    $forcast['fahrenheit'],
                    $forcast['feelsLikeTemp'],
                    $forcast['humidity'],
                    $forcast['windSpeed'],
                );
            }, $forcasts));
            $response->setContent($csv);
            return $response;
        }
        return $this->json([
            'city' => $city,
            'countryCode' => $countryCode,
            'forcasts' => $forcasts,
        ]);
    }
}
