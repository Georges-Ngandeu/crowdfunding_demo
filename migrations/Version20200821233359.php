<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821233359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` CHANGE admin_createdat admin_createdat DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE manager CHANGE manager_createdat manager_createdat DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriber CHANGE subscriber_createdat subscriber_createdat DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` CHANGE admin_createdat admin_createdat DATETIME NOT NULL');
        $this->addSql('ALTER TABLE manager CHANGE manager_createdat manager_createdat DATETIME NOT NULL');
        $this->addSql('ALTER TABLE subscriber CHANGE subscriber_createdat subscriber_createdat DATETIME NOT NULL');
    }
}
