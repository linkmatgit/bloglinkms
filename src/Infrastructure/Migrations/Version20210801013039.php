<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801013039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT fk_2f9b9cf5727aca70');
        $this->addSql('DROP INDEX idx_2f9b9cf5727aca70');
        $this->addSql('ALTER TABLE mods_category RENAME COLUMN parent_id TO parentcat_id');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT FK_2F9B9CF5A0A4D17C FOREIGN KEY (parentcat_id) REFERENCES mods_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2F9B9CF5A0A4D17C ON mods_category (parentcat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT FK_2F9B9CF5A0A4D17C');
        $this->addSql('DROP INDEX IDX_2F9B9CF5A0A4D17C');
        $this->addSql('ALTER TABLE mods_category RENAME COLUMN parentcat_id TO parent_id');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT fk_2f9b9cf5727aca70 FOREIGN KEY (parent_id) REFERENCES mods_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2f9b9cf5727aca70 ON mods_category (parent_id)');
    }
}
