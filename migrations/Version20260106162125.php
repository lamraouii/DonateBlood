<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260106162125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donor_profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, blood_type VARCHAR(4) NOT NULL, birthdate DATE NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, cine VARCHAR(10) NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_F7DE98B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7DE98B88977A4A0 ON donor_profile (cine)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7DE98B8A76ED395 ON donor_profile (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE donor_profile');
    }
}
