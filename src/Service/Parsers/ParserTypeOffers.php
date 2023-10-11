<?php

namespace App\Service\Parsers;


use App\Service\City;

// Обработка файлов offers*
class ParserTypeOffers extends Abstract1CParser
{
    public const FILE_MASK = 'offers*.xml';
    // Внутренние переменные для обработки данных
    protected string $city;
    protected array $item;

    // Правила
    protected array $rules = [
        'ПакетПредложений -> Наименование /// 2 -- 1' => 'getCity',
        'ПакетПредложений -> Предложения -> Предложение /// 3 -- 1' => 'productStart',
        'ПакетПредложений -> Предложения /// 3 -- 2' => 'productEnd',
        'ПакетПредложений -> Предложения -> Предложение -> Код /// 4 -- 1' => 'productCod',
        'ПакетПредложений -> Предложения -> Предложение -> Наименование /// 4 -- 1' => 'productName',
        'ПакетПредложений -> Предложения -> Предложение -> Количество /// 4 -- 1' => 'productQty',
        'ПакетПредложений -> Предложения -> Предложение -> Цены -> Цена -> ЦенаЗаЕдиницу /// 6 -- 1' => 'productPrice',
    ];

    protected function getCity(): void
    {
        $this->reader->readString();
        preg_match('/Пакет предложений \((.*)\)/u', $this->reader->readString(), $output);
        if (!empty($output[1])) {
            $this->city = trim($output[1]);
        } else {
            exit; // TODO
        }
        //dump($this->city);exit;
    }

    protected function productStart(): void
    {
        $this->item = [
            'code' => '',
            'name' => '',
            'qty' => 0,
            'price' => null,
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

    protected function productQty(): void
    {
        $this->item['qty'] = $this->reader->readString();
    }

    protected function productPrice(): void
    {
        if (is_null($this->item['price'])) {
            $this->item['price'] = $this->reader->readString();
        }
    }

    /*
     * Обработка и сохранение элементов
     */
    public function saveItems(array $items): void
    {
        $cityCode = City::getCode($this->city);
        if ($cityCode) {
            $field_price = 'price_' . $cityCode;
            $field_qty = 'quantity_' . $cityCode;
            $this->saver->save(
                ['name', 'code', $field_price, $field_qty],
                array_map(
                    static function ($item) use ($field_price, $field_qty) {
                        $ret = [
                            'name' => $item['name'],
                            'code' => (int)$item['code'],
                        ];
                        $ret[$field_price] = (int)$item['price'];
                        $ret[$field_qty] = (int)$item['qty'];

                        return $ret;
                    },
                    $items
                )
            );
        } else {
            // TODO логирование
        }
    }
}
