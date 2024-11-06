<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'app:weather:location',
    description: 'Fetches and displays weather data for a specific location.',
)]
class WeatherLocationCommand extends Command
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
            ->addArgument('locationId', InputArgument::REQUIRED, 'The ID of the location');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = (int) $input->getArgument('locationId');
        $location = $this->locationRepository->find($locationId);

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
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getLocation()->getCity(),
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
