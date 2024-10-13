<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{countryCode?}', name: 'app_weather')]
    public function city(string $city, ?string $countryCode, LocationRepository $locationRepository, MeasurementRepository $measurementRepository): Response
    {
        $location = $locationRepository->findOneByCityAndCountry($city, $countryCode);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
