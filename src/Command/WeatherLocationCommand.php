<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Displays forcast for a given location',
)]
class WeatherLocationCommand extends Command
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil $weatherUtil,
//        string $name = null,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'Location ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationID = $input->getArgument('id');
        $location = $this->locationRepository->find($locationID);

        $forcast = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Forcast for %s, %s', $location->getCity(), $location->getCountry()));
        foreach ($forcast as $forcastItem) {
            $io->writeln(sprintf(
                '%s: %s°C, real feel: %s°C, %s%% humidity, %s m/s wind speed',
                $forcastItem->getDate()->format('Y-m-d'),
                $forcastItem->getFeelsLikeTemp(),
                $forcastItem->getTemperature(),
                $forcastItem->getHumidity(),
                $forcastItem->getWindSpeed(),
            ));
        }

        return Command::SUCCESS;
    }
}
