<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'weather:city:country',
    description: 'Add a short description for your command',
)]
class WeatherCityCountryCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private LocationRepository $locationRepository;

    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
        $this->locationRepository = $locationRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'The country code of the location')
            ->addArgument('city', InputArgument::REQUIRED, 'The name of the city');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $countryCode = $input->getArgument('countryCode');
        $city = $input->getArgument('city');

        // Search for the location based on country code and city name
        $location = $this->locationRepository->findOneBy(['country' => $countryCode, 'city' => $city]);

        if (!$location) {
            $output->writeln('<error>Location not found.</error>');
            return Command::FAILURE;
        }

        // Fetch the weather data
        $measurements = $this->weatherUtil->getWeatherForLocation($location);

        if (empty($measurements)) {
            $output->writeln('<info>No weather data available for this location.</info>');
            return Command::SUCCESS;
        }

        // Display the weather data
        foreach ($measurements as $measurement) {
            $output->writeln(sprintf(
                "Location: %s\n" .
                    "Date: %s\n" .
                    "Temperature: %s°C\n" .
                    "Humidity: %s%%\n" .
                    "Wind Speed: %s m/s\n" .
                    "Wind Direction: %s°\n" .
                    "Pressure: %s hPa\n" .
                    "Cloud Cover: %s\n",
                $measurement->getLocation()->getCity(),
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getTemperature(),
                $measurement->getAirHumidity(),
                $measurement->getWindSpeed(),
                $measurement->getWindDirection(),
                $measurement->getPressure(),
                $measurement->getCloudCover()
            ));
        }

        return Command::SUCCESS;
    }
}
