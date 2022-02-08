<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821130224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` ADD admin_email VARCHAR(255) DEFAULT NULL, ADD admin_username VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manager ADD manager_username VARCHAR(255) DEFAULT NULL, ADD manager_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriber ADD subscriber_email VARCHAR(255) DEFAULT NULL, ADD subscriber_username VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP admin_email, DROP admin_username');
        $this->addSql('ALTER TABLE manager DROP manager_username, DROP manager_email');
        $this->addSql('ALTER TABLE subscriber DROP subscriber_email, DROP subscriber_username');
    }
}
