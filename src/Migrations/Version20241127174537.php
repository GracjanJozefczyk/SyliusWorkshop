<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241127174537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between Manufacturer and Channel';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE sylius_manufacturer_channels (manufacturer_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_2F21888DA23B42D (manufacturer_id), INDEX IDX_2F21888D72F5A1AA (channel_id), PRIMARY KEY(manufacturer_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_manufacturer_channels ADD CONSTRAINT FK_2F21888DA23B42D FOREIGN KEY (manufacturer_id) REFERENCES sylius_manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_manufacturer_channels ADD CONSTRAINT FK_2F21888D72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_manufacturer_channels DROP FOREIGN KEY FK_2F21888DA23B42D');
        $this->addSql('ALTER TABLE sylius_manufacturer_channels DROP FOREIGN KEY FK_2F21888D72F5A1AA');
        $this->addSql('DROP TABLE sylius_manufacturer_channels');
    }
}
