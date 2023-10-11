<?php

namespace App\Service\Savers\Drivers;

use Doctrine\ORM\EntityManagerInterface;

// Драйвер для Mysql (MariaDB)
class MysqlBatchItemSaverDriver implements IBatchItemSaverDriver
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function sqlBeginPrepare(string $table, array $fields): string
    {
        return sprintf("INSERT INTO `%s` (%s) VALUES ", $table, implode(', ', $fields));
    }

    public function sqlItemPrepare(string $table, string $unic, array $fields, array $item): string
    {
        $sql_data = [];
        foreach ($fields as $field) {
            $value = $item[$field];
            if ($field === 'code' || str_contains($field, 'price_') || str_contains($field, 'quantity_')) {
                $value = (int)$value;
            } elseif ($field === 'weight') {
                $value = number_format((float)$value, 3, '.', '');
            } else {
                $value = $this->em->getConnection()->quote($value);
            }
            $sql_data[] = $value;
        }

        return vsprintf(
            " (%s, %d, %s, %s) ",
            $sql_data
        );
    }
}