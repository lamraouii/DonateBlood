<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260107140824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__donation AS SELECT id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id FROM donation');
        $this->addSql('DROP TABLE donation');
        $this->addSql('CREATE TABLE donation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, blood_type VARCHAR(4) DEFAULT NULL, quantity INTEGER NOT NULL, donated_at DATE NOT NULL, status VARCHAR(20) NOT NULL, donor_profile_id INTEGER NOT NULL, blood_center_id INTEGER NOT NULL, CONSTRAINT FK_31E581A075FF95AE FOREIGN KEY (donor_profile_id) REFERENCES donor_profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31E581A0FF2FCA25 FOREIGN KEY (blood_center_id) REFERENCES blood_center (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO donation (id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id) SELECT id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id FROM __temp__donation');
        $this->addSql('DROP TABLE __temp__donation');
        $this->addSql('CREATE INDEX IDX_31E581A075FF95AE ON donation (donor_profile_id)');
        $this->addSql('CREATE INDEX IDX_31E581A0FF2FCA25 ON donation (blood_center_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__donation AS SELECT id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id FROM donation');
        $this->addSql('DROP TABLE donation');
        $this->addSql('CREATE TABLE donation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, blood_type VARCHAR(4) NOT NULL, quantity INTEGER NOT NULL, donated_at DATE NOT NULL, status VARCHAR(20) NOT NULL, donor_profile_id INTEGER NOT NULL, blood_center_id INTEGER NOT NULL, CONSTRAINT FK_31E581A075FF95AE FOREIGN KEY (donor_profile_id) REFERENCES donor_profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31E581A0FF2FCA25 FOREIGN KEY (blood_center_id) REFERENCES blood_center (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO donation (id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id) SELECT id, blood_type, quantity, donated_at, status, donor_profile_id, blood_center_id FROM __temp__donation');
        $this->addSql('DROP TABLE __temp__donation');
        $this->addSql('CREATE INDEX IDX_31E581A075FF95AE ON donation (donor_profile_id)');
        $this->addSql('CREATE INDEX IDX_31E581A0FF2FCA25 ON donation (blood_center_id)');
    }
}
