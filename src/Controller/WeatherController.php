<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{countryCode?}', name: 'app_weather', requirements: ['id'=>'\d+'])]
    public function city(string $city, ?string $countryCode, ForcastRepository $forcast_repo): Response
    {
        $forcasts = $forcast_repo->findByCityAndCountryCode($city, $countryCode);
        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'country'=>$countryCode,
            'forcasts' => $forcasts,
        ]);
    }
}
