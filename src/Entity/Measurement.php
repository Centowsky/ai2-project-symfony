<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $temperature = null;

    #[ORM\Column]
    private ?float $air_humidity = null;

    #[ORM\Column]
    private ?float $wind_speed = null;

    #[ORM\Column(length: 255)]
    private ?string $wind_direction = null;

    #[ORM\Column]
    private ?float $pressure = null;

    #[ORM\Column(length: 255)]
    private ?string $cloud_cover = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date ?? new \DateTime();

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function getFahrenheit(): float
    {
        return (float)$this->getTemperature() * 9 / 5 + 32;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getAirHumidity(): ?float
    {
        return $this->air_humidity;
    }

    public function setAirHumidity(float $air_humidity): static
    {
        $this->air_humidity = $air_humidity;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(float $wind_speed): static
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(string $wind_direction): static
    {
        $this->wind_direction = $wind_direction;

        return $this;
    }

    public function getPressure(): ?float
    {
        return $this->pressure;
    }

    public function setPressure(float $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getCloudCover(): ?string
    {
        return $this->cloud_cover;
    }

    public function setCloudCover(string $cloud_cover): static
    {
        $this->cloud_cover = $cloud_cover;

        return $this;
    }
}
