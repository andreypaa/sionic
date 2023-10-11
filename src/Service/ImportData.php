<?php

namespace App\Service;

use App\Service\Parsers\Abstract1CParser;
use App\Service\Parsers\ParserTypeImport;
use App\Service\Parsers\ParserTypeOffers;
use Symfony\Component\Console\Style\SymfonyStyle;

/*
 * Основной класс, отвечающий за процесс импорта данных
 */
class ImportData
{
    public const BATCH_SIZE = 500;
    private array $parsers = [];

    public function __construct(ParserTypeImport $parserTypeImport, ParserTypeOffers $parserTypeOffers)
    {
        // Определяем какие типы файлов сможем обрабатывать
        $this->parsers[] = $parserTypeImport;
        $this->parsers[] = $parserTypeOffers;
    }

    // Обрабатываем целевую директорию
    public function processDir(string $importDir, SymfonyStyle $io): void
    {
        /** @var Abstract1CParser $parser */
        foreach ($this->parsers as $parser) {
            if (!empty($parser::FILE_MASK) && is_dir($importDir)) {
                // Ищем подходящие файлы
                $files = glob($importDir . '/' . $parser::FILE_MASK);
                if ($files) {
                    foreach ($files as $file) {
                        // Засекаем время
                        $io->text(sprintf('Process file: %s', $file));
                        $time_start = microtime(true);
                        // Обрабатываем конкретный файл
                        $parser->processFile($file, self::BATCH_SIZE);
                        $time_exec = microtime(true) - $time_start;
                        $io->text(sprintf('File processed by %s sec', $time_exec));
                    }
                }
            }
        }
    }
}
