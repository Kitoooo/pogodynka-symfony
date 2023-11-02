<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forcast;
use App\Repository\ForcastRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly ForcastRepository $forcastRepository,
    )
    {}

    /**
     * @return Forcast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->forcastRepository->findByLocation($location);
    }

    /**
     * @return Forcast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        return $this->getWeatherForLocation($location);
    }
}
