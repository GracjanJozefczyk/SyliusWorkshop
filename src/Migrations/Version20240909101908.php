<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240909101908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add manufacturer entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE sylius_manufacturer (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_product ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD CONSTRAINT FK_677B9B74A23B42D FOREIGN KEY (manufacturer_id) REFERENCES sylius_manufacturer (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_677B9B74A23B42D ON sylius_product (manufacturer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product DROP FOREIGN KEY FK_677B9B74A23B42D');
        $this->addSql('DROP TABLE sylius_manufacturer');
        $this->addSql('DROP INDEX IDX_677B9B74A23B42D ON sylius_product');
        $this->addSql('ALTER TABLE sylius_product DROP manufacturer_id');
    }
}
