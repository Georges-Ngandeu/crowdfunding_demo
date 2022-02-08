<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200820175811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, admin_createdat DATETIME NOT NULL, admin_firstname VARCHAR(255) DEFAULT NULL, admin_lastname VARCHAR(255) DEFAULT NULL, admin_region VARCHAR(255) DEFAULT NULL, admin_phone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', user_type VARCHAR(255) DEFAULT NULL, session_store VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user_group (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_583D1F3EA76ED395 (user_id), INDEX IDX_583D1F3EFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, manager_createdat DATETIME NOT NULL, manager_firstname VARCHAR(255) DEFAULT NULL, manager_lastname VARCHAR(255) DEFAULT NULL, manager_region VARCHAR(255) DEFAULT NULL, manager_phone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_FA2425B9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, project_name VARCHAR(255) NOT NULL, project_shortdescription VARCHAR(255) NOT NULL, project_cost VARCHAR(255) NOT NULL, project_engaged DOUBLE PRECISION DEFAULT NULL, project_startdate DATETIME NOT NULL, project_enddate DATETIME NOT NULL, project_images JSON NOT NULL, project_documents JSON NOT NULL, project_creationdate DATETIME NOT NULL, project_mainimage VARCHAR(255) NOT NULL, project_videourl VARCHAR(255) NOT NULL, project_publish TINYINT(1) NOT NULL, project_longdescription LONGTEXT NOT NULL, project_group VARCHAR(255) DEFAULT NULL, project_numberaction DOUBLE PRECISION NOT NULL, project_priceaction DOUBLE PRECISION DEFAULT NULL, project_minnumberaction DOUBLE PRECISION NOT NULL, project_numbercontributions DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriber (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscriber_createdat DATETIME NOT NULL, UNIQUE INDEX UNIQ_AD005B69A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriber_project (id INT AUTO_INCREMENT NOT NULL, subscriber_id_id INT NOT NULL, project_id_id INT NOT NULL, manager_id_id INT DEFAULT NULL, subscription_createdate DATETIME NOT NULL, subscription_hectare_number DOUBLE PRECISION NOT NULL, subscription_number DOUBLE PRECISION NOT NULL, subscription_mobile_account JSON NOT NULL, subscription_bank_account JSON DEFAULT NULL, subscription_campaign_awareness VARCHAR(255) NOT NULL, subscription_partner JSON DEFAULT NULL, INDEX IDX_3D3A6C6944E41CB0 (subscriber_id_id), INDEX IDX_3D3A6C696C1197C9 (project_id_id), INDEX IDX_3D3A6C69569B5E6D (manager_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE fos_user_group ADD CONSTRAINT FK_583D1F3EA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE fos_user_group ADD CONSTRAINT FK_583D1F3EFE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE subscriber ADD CONSTRAINT FK_AD005B69A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE subscriber_project ADD CONSTRAINT FK_3D3A6C6944E41CB0 FOREIGN KEY (subscriber_id_id) REFERENCES subscriber (id)');
        $this->addSql('ALTER TABLE subscriber_project ADD CONSTRAINT FK_3D3A6C696C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE subscriber_project ADD CONSTRAINT FK_3D3A6C69569B5E6D FOREIGN KEY (manager_id_id) REFERENCES manager (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fos_user_group DROP FOREIGN KEY FK_583D1F3EFE54D947');
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76A76ED395');
        $this->addSql('ALTER TABLE fos_user_group DROP FOREIGN KEY FK_583D1F3EA76ED395');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9A76ED395');
        $this->addSql('ALTER TABLE subscriber DROP FOREIGN KEY FK_AD005B69A76ED395');
        $this->addSql('ALTER TABLE subscriber_project DROP FOREIGN KEY FK_3D3A6C69569B5E6D');
        $this->addSql('ALTER TABLE subscriber_project DROP FOREIGN KEY FK_3D3A6C696C1197C9');
        $this->addSql('ALTER TABLE subscriber_project DROP FOREIGN KEY FK_3D3A6C6944E41CB0');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE fos_group');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE fos_user_group');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE subscriber');
        $this->addSql('DROP TABLE subscriber_project');
    }
}
