<?php

namespace App\Service\Savers\Drivers;

interface IBatchItemSaverDriver
{
    public function sqlBeginPrepare(string $table, array $fields): string;

    public function sqlItemPrepare(string $table, string $unic, array $fields, array $item): string;

}