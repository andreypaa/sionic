<?php

namespace App\Service\Parsers;

use App\Service\Savers\BatchItemSaver;
use RuntimeException;
use XMLReader;

/*
 * Общий класс обработки (парсинга) xml выгрузок
 */
abstract class Abstract1CParser {

    // Маска поиска подходящих файлов
    public const FILE_MASK = '';
    // Сколько итемов за раз, записываем в базу, по умолчанию
    public const BATCH_SIZE_DEFAULT = 1000;
    protected XMLReader $reader;
    // Временное хранилище итемов
    protected array $items = [];
    // Правила обработки xml файла
    protected array $rules = [];
    // Объект для сохранения данных в БД
    protected BatchItemSaver $saver;
    // Сколько итемов за раз, записываем в базу, текущее
    protected int $batchSize;

    public function __construct(BatchItemSaver $saver)
    {
        $this->saver = $saver;
    }

    /*
     * Инициализируем XMLReader, задаем параметры
     */
    private function initBeforeProcess(string $file,  int $batchSize = null): void
    {
        if (is_readable($file)) {
            $this->reader = XMLReader::open($file);
        } else {
            throw new RuntimeException('XML file {' . $file . '} not exists!');
        }
        $this->batchSize = $batchSize ?: self::BATCH_SIZE_DEFAULT;
    }

    abstract public function saveItems(array $items): void;

    // Событие при очередном появлении итема
    public function onNewItem(): void
    {
        if (count($this->items) > $this->batchSize) {
            // Если достигли нужного размера, то пишем в базу
            $this->saveItems($this->items);
            $this->items = [];
        }
    }

    // Событие при окончании парсинга файла
    public function onEndProcess(): void
    {
        if (!empty($this->items)) {
            // Записываем оставшиеся элементы
            $this->saveItems($this->items);
            $this->items = [];
        }
    }

    // Запускаем обработку файла
    public function processFile(string $file, int $batchSize): void
    {
        $this->initBeforeProcess($file, $batchSize);
        $path = [];

        $this->reader->read();

        while($this->reader->read()) {
            $status = 0;
            if($this->reader->nodeType === XMLREADER::ELEMENT) {
                $path[] = $this->reader->localName; // дополняем путь
                $status = 1;
            }
            if ($this->reader->nodeType === XMLReader::END_ELEMENT || $this->reader->isEmptyElement) {
                array_pop($path); // убавляем путь
                $status = 2;
            }

            if ($status === 1 || $status === 2) {
                // Формируем путь элемента
                $key = implode(' -> ', $path) . ' /// ' . $this->reader->depth . ' -- ' . $status;
                //dump('path - ' . $key );

                // Обрабатываем правила, если они нашлись для пути
                if (!empty($this->rules[$key])) {
                    $method = $this->rules[$key];
                    if (method_exists($this, $method)) {
                        $this->$method();
                    }
                }
            }
        }

        // Триггерим событие
        $this->onEndProcess();
    }
}
