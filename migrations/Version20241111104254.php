<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241111104254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates shop products table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE shop_products (sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(sku)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE shop_products');
    }
}
