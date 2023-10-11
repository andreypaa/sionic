<?php

namespace App\Service;

/**
 * Класс - заглушка, для определения кодов городов.
 */
class City
{
    // База известных городов
    public const CITIES = [
        'москва' => 1,
        'санкт-петербург' => 2,
        'самара' => 3,
        'саратов' => 4,
        'казань' => 5,
        'новосибирск' => 6,
        'челябинск' => 7,
        'деловые линии челябинск' => 8,
    ];

    // Получаем код города по названию
    public static function getCode(string $cityName): int
    {
        $city = mb_strtolower(trim($cityName));

        return !empty(self::CITIES[$city]) ? self::CITIES[$city] : 0;
    }
}