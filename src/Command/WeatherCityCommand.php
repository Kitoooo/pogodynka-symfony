<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Add a short description for your command',
)]
class WeatherCityCommand extends Command
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil $weatherUtil,
        string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('city', InputArgument::REQUIRED, 'Full city name.')
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country code. e.g. PL for Poland' )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $city = $input->getArgument('city');
        $countryCode = $input->getArgument('countryCode');

        $forcast = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $city);

        $io->writeln(sprintf('Forcast for %s, %s', $city, $countryCode));
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
