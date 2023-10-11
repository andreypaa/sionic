<?php

namespace App\Service\Savers;

use App\Service\Savers\Drivers\IBatchItemSaverDriver;
use App\Service\Savers\Drivers\MysqlBatchItemSaverDriver;
use Doctrine\ORM\EntityManagerInterface;

// Сервис сохранения элементов в БД
class BatchItemSaver
{
    public const DB_TABLE = 'items';
    public const DB_TABLE_UNIC = 'code';
    private IBatchItemSaverDriver $driver;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $dbParams = $this->em->getConnection()->getParams();
        if (!empty($dbParams['driver']) && str_contains($dbParams['driver'], 'mysql')) {
            $this->driver = new MysqlBatchItemSaverDriver($entityManager);
        }
    }

    /*
     * При помощи определенного драйвера подготавливаем SQL Insert и выполняем его
     */
    public function save(array $fields, array $items): ?string
    {
        $sql = $this->driver->sqlBeginPrepare(self::DB_TABLE, $fields);
        $sqlItems = [];
        foreach ($items as $item) {
            $sqlItems[] = $this->driver->sqlItemPrepare(self::DB_TABLE, self::DB_TABLE_UNIC, $fields, $item);
        }
        $sql .= implode(' , ', $sqlItems);
        $sql .= ' ON DUPLICATE KEY UPDATE ' . implode(
            ' , ',
                array_map(
                    static function ($field) { return sprintf(' `%s` = VALUES(`%s`) ', $field, $field); },
                    array_diff($fields, [self::DB_TABLE_UNIC])
                )
        );

        try {
            $this->em->getConnection()->prepare($sql)->executeQuery();
        } catch (\Throwable $exception) {
            die($exception->getMessage());
        }

        return null;
    }
}