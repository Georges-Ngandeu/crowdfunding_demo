<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821071836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber ADD subscriber_firstname VARCHAR(255) DEFAULT NULL, ADD subscriber_lastname VARCHAR(255) DEFAULT NULL, ADD subscriber_enterprise_name VARCHAR(255) DEFAULT NULL, ADD subscriber_director_firstname VARCHAR(255) DEFAULT NULL, ADD subscriber_director_lastname VARCHAR(255) DEFAULT NULL, ADD subscriber_birthdate DATETIME DEFAULT NULL, ADD subscriber_birth_place VARCHAR(255) DEFAULT NULL, ADD subscriber_identity_card_number VARCHAR(255) DEFAULT NULL, ADD subscriber_identity_card_delivery_date DATETIME DEFAULT NULL, ADD subscriber_identity_card_delivery_place VARCHAR(255) DEFAULT NULL, ADD subscriber_telephone VARCHAR(255) DEFAULT NULL, ADD subscriber_profession VARCHAR(255) DEFAULT NULL, ADD subscriber_town VARCHAR(255) DEFAULT NULL, ADD subscriber_marital_status VARCHAR(255) DEFAULT NULL, ADD subscriber_professional_status VARCHAR(255) DEFAULT NULL, ADD subscriber_revenu VARCHAR(255) DEFAULT NULL, ADD subscriber_revenu_origine VARCHAR(255) DEFAULT NULL, ADD subscriber_image VARCHAR(255) DEFAULT NULL, ADD subscriber_language VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriber DROP subscriber_firstname, DROP subscriber_lastname, DROP subscriber_enterprise_name, DROP subscriber_director_firstname, DROP subscriber_director_lastname, DROP subscriber_birthdate, DROP subscriber_birth_place, DROP subscriber_identity_card_number, DROP subscriber_identity_card_delivery_date, DROP subscriber_identity_card_delivery_place, DROP subscriber_telephone, DROP subscriber_profession, DROP subscriber_town, DROP subscriber_marital_status, DROP subscriber_professional_status, DROP subscriber_revenu, DROP subscriber_revenu_origine, DROP subscriber_image, DROP subscriber_language');
    }
}
