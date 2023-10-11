<?php

namespace App\Service\Savers\Drivers;

use App\Service\Savers\Drivers\IBatchItemSaverDriver;

/*
 * Данная БД у меня не установлена, поэтому не стал реализовывать данный вид драйвера.
 * Но предполагаю, что в нем было бы логично использовать инструкцию UPSERT
 */
class PostgresqlBatchItemSaverDriver implements IBatchItemSaverDriver
{

    public function sqlBeginPrepare(string $table, array $fields): string
    {
        // TODO: Implement sqlBeginPrepare() method.
    }

    public function sqlItemPrepare(string $table, string $unic, array $fields, array $item): string
    {
        // TODO: Implement sqlItemPrepare() method.
    }
}