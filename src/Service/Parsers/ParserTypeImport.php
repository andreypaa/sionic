<?php

namespace App\Service\Parsers;

// Обработка файлов import*
class ParserTypeImport extends Abstract1CParser
{
    public const FILE_MASK = 'import*.xml';

    // Внутренние переменные для обработки данных
    protected string $city;
    protected array $item;
    protected array $changeability;

    // Правила
    protected array $rules = [
        'Каталог -> Наименование /// 2 -- 1' => 'getCity',
        'Каталог -> Товары -> Товар /// 3 -- 1' => 'productStart',
        'Каталог -> Товары /// 3 -- 2' => 'productEnd',
        'Каталог -> Товары -> Товар -> Код /// 4 -- 1' => 'productCod',
        'Каталог -> Товары -> Товар -> Наименование /// 4 -- 1' => 'productName',
        'Каталог -> Товары -> Товар -> Вес /// 4 -- 1' => 'productWeight',
        'Каталог -> Товары -> Товар -> Взаимозаменяемости -> Взаимозаменяемость /// 5 -- 1' => 'changeabilityStart',
        'Каталог -> Товары -> Товар -> Взаимозаменяемости /// 5 -- 2' => 'changeabilityEnd',
        'Каталог -> Товары -> Товар -> Взаимозаменяемости -> Взаимозаменяемость -> Марка /// 6 -- 1' => 'changeabilityMark',
        'Каталог -> Товары -> Товар -> Взаимозаменяемости -> Взаимозаменяемость -> Модель /// 6 -- 1' => 'changeabilityModel',
        'Каталог -> Товары -> Товар -> Взаимозаменяемости -> Взаимозаменяемость -> КатегорияТС /// 6 -- 1' => 'changeabilityCategory',
    ];

    protected function getCity(): void
    {
        $this->city = $this->reader->readString();
    }

    protected function productStart(): void
    {
        $this->item = [
            'code' => '',
            'name' => '',
            'weight' => '',
            'city' => $this->city,
            'changeability' => [],
        ];
    }

    protected function productEnd(): void
    {
        $this->items[] = $this->item;
        $this->onNewItem();
        $this->item = [];

    }

    protected function productCod(): void
    {
        $this->item['code'] = $this->reader->readString();
    }

    protected function productName(): void
    {
        $this->item['name'] = $this->reader->readString();
    }

    protected function productWeight(): void
    {
        $this->item['weight'] = $this->reader->readString();
    }

    protected function changeabilityStart(): void
    {
        $this->changeability = [];
    }

    protected function changeabilityEnd(): void
    {
        $this->item['changeability'][] = $this->changeability;
        $this->changeability = [];

    }

    protected function changeabilityMark(): void
    {
        $this->changeability['mark'] = $this->reader->readString();
    }

    protected function changeabilityModel(): void
    {
        $this->changeability['model'] = $this->reader->readString();
    }

    protected function changeabilityCategory(): void
    {
        $this->changeability['category_ts'] = $this->reader->readString();
    }

    /*
     * Обработка и сохранение элементов
     */
    public function saveItems(array $items): void
    {
        $this->saver->save(
            ['name', 'code', 'weight', 'usagetxt'],
            array_map(
                static function ($item) {
                    $usage = '';
                    if (!empty($item['changeability'])) {
                        $usage = implode('|', array_map(static function ($u) {
                            return sprintf('%s-%s-%s', $u['mark'] ?? '', $u['model'] ?? '', $u['category_ts'] ?? '');
                        }, $item['changeability']));
                    }
                    return [
                        'name' => $item['name'],
                        'code' => (int)$item['code'],
                        'weight' => $item['code'],
                        'usagetxt' => $usage,
                    ];
                },
                $items
            )
        );
    }
}
