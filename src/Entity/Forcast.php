<?php

namespace App\Entity;

use App\Repository\ForcastRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForcastRepository::class)]
class Forcast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\ManyToOne(inversedBy: 'forcasts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column]
    private ?float $feels_like_temp = null;

    #[ORM\Column]
    private ?int $humidity = null;

    #[ORM\Column]
    private ?int $wind_speed = null;

    #[ORM\Column]
    private ?int $precipation_probability = null;

    #[ORM\Column(nullable: true)]
    private ?float $precipation = null;

    #[ORM\Column]
    private ?int $atmospheric_pressure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getFeelsLikeTemp(): ?float
    {
        return $this->feels_like_temp;
    }

    public function setFeelsLikeTemp(float $feels_like_temp): static
    {
        $this->feels_like_temp = $feels_like_temp;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWindSpeed(): ?int
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(int $wind_speed): static
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getPrecipationProbability(): ?int
    {
        return $this->precipation_probability;
    }

    public function setPrecipationProbability(int $precipation_probability): static
    {
        $this->precipation_probability = $precipation_probability;

        return $this;
    }

    public function getPrecipation(): ?float
    {
        return $this->precipation;
    }

    public function setPrecipation(?float $precipation): static
    {
        $this->precipation = $precipation;

        return $this;
    }

    public function getAtmosphericPressure(): ?int
    {
        return $this->atmospheric_pressure;
    }

    public function setAtmosphericPressure(int $atmospheric_pressure): static
    {
        $this->atmospheric_pressure = $atmospheric_pressure;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getFahrenheit(): ?float
    {
        return $this->temperature * 9 / 5 + 32;
    }
}
