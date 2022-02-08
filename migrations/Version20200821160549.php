<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821160549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE otp_line (id INT AUTO_INCREMENT NOT NULL, segment_id INT DEFAULT NULL, identity VARCHAR(255) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, otp INT DEFAULT NULL, status TINYINT(1) NOT NULL, INDEX IDX_35FFA777DB296AAD (segment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE otp_segment (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, sms TINYINT(1) NOT NULL, email TINYINT(1) NOT NULL, size INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE params (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, cle VARCHAR(50) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE otp_line ADD CONSTRAINT FK_35FFA777DB296AAD FOREIGN KEY (segment_id) REFERENCES otp_segment (id)');
        $this->addSql('ALTER TABLE subscriber_project CHANGE subscription_hectare_number subscription_hectare_number DOUBLE PRECISION DEFAULT NULL, CHANGE subscription_number subscription_number DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE otp_line DROP FOREIGN KEY FK_35FFA777DB296AAD');
        $this->addSql('DROP TABLE otp_line');
        $this->addSql('DROP TABLE otp_segment');
        $this->addSql('DROP TABLE params');
        $this->addSql('ALTER TABLE subscriber_project CHANGE subscription_hectare_number subscription_hectare_number DOUBLE PRECISION NOT NULL, CHANGE subscription_number subscription_number DOUBLE PRECISION NOT NULL');
    }
}
