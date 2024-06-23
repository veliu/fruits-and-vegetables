<?php declare(strict_types=1);

namespace App\Command;

use App\Dto\Food\Fruit\Fruit;
use App\Dto\Food\Fruit\FruitCollection;
use App\Dto\Food\Vegetable\Vegetable;
use App\Dto\Food\Vegetable\VegetableCollection;
use App\Service\StorageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:read-request', 'Reads a json file and separates the content by fruits and vegetables')]
final class ReadRequestCommand extends Command
{
    private const ARGUMENT_FILE = 'file';
    private const OPTION_UNIT = 'unit';
    private const OPTION_SEARCH = 'search';
    protected function configure(): void
    {
        $this->addArgument(self::ARGUMENT_FILE, InputArgument::REQUIRED, 'path of request file');
        $this->addOption(self::OPTION_UNIT, mode: InputArgument::OPTIONAL, default: 'g');
        $this->addOption(self::OPTION_SEARCH, mode: InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument(self::ARGUMENT_FILE);
        $unit = $input->getOption(self::OPTION_UNIT);
        $searchTerm = $input->getOption(self::OPTION_SEARCH);

        $jsonRequest = file_get_contents($file);

        $storageService = new StorageService($jsonRequest);

        $io = new SymfonyStyle($input, $output);

        try {
            $fruitCollection = new FruitCollection($storageService->filterFoodByType(Fruit::class));
            $vegetableCollection = new VegetableCollection($storageService->filterFoodByType(Vegetable::class));
        } catch (\InvalidArgumentException $e) {
            $io->error(sprintf('Json file is invalid: %s', $e->getMessage()));
            return Command::INVALID;
        }

        $fruits = $fruitCollection->list($searchTerm, $unit);
        $io->info(sprintf('Your request contains %d fruits', count($fruits)));
        $io->listing($fruits);

        $vegetables = $vegetableCollection->list($searchTerm, $unit);
        $io->info(sprintf('Your request contains %d vegetables', count($vegetables)));
        $io->listing($vegetables);

        return Command::SUCCESS;
    }
}