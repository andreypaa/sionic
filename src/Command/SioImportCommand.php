<?php

namespace App\Command;

use App\Service\ImportData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'sio:import',
    description: 'Команда для импорта xml выгрузок из директории var/data',
)]
class SioImportCommand extends Command
{
    private ImportData $importData;
    private string $scanDir;

    public function __construct(ImportData $importData, string $varDir, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->importData = $importData;
        $this->scanDir = $varDir . '/var/data';
    }

    protected function configure(): void
    {
        $this
            ->addArgument('batch-size', InputArgument::OPTIONAL, 'Batch size of sql inserts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $batchSize = $input->getArgument('batch-size');

        /*if ($batchSize) {
            $io->note(sprintf('You passed an argument: %s', $batchSize));
        }*/

        $time_start = microtime(true);
        // запускаем основной процесс
        $this->importData->processDir($this->scanDir, $io);
        $time_exec = microtime(true) - $time_start;

        $io->success(sprintf('All files processed by: %s sec', $time_exec));

        return Command::SUCCESS;
    }
}
