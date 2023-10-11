<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011160758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(512) DEFAULT NULL, code BIGINT UNSIGNED NOT NULL, weight NUMERIC(12, 3) DEFAULT NULL, usagetxt TEXT DEFAULT NULL, quantity_1 INT NOT NULL DEFAULT 0, quantity_2 INT NOT NULL DEFAULT 0, quantity_3 INT NOT NULL DEFAULT 0, quantity_4 INT NOT NULL DEFAULT 0, quantity_5 INT NOT NULL DEFAULT 0, quantity_6 INT NOT NULL DEFAULT 0, quantity_7 INT NOT NULL DEFAULT 0, quantity_8 INT NOT NULL DEFAULT 0, price_1 INT NOT NULL DEFAULT 0, price_2 INT NOT NULL DEFAULT 0, price_3 INT NOT NULL DEFAULT 0, price_4 INT NOT NULL DEFAULT 0, price_5 INT NOT NULL DEFAULT 0, price_6 INT NOT NULL DEFAULT 0, price_7 INT NOT NULL DEFAULT 0, price_8 INT NOT NULL DEFAULT 0, UNIQUE INDEX codeindex (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE items');
    }
}
