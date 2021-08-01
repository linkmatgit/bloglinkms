<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801014116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT fk_2f9b9cf5a0a4d17c');
        $this->addSql('DROP INDEX idx_2f9b9cf5a0a4d17c');
        $this->addSql('ALTER TABLE mods_category RENAME COLUMN parentcat_id TO parent_id');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT FK_2F9B9CF5727ACA70 FOREIGN KEY (parent_id) REFERENCES mods_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2F9B9CF5727ACA70 ON mods_category (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT FK_2F9B9CF5727ACA70');
        $this->addSql('DROP INDEX IDX_2F9B9CF5727ACA70');
        $this->addSql('ALTER TABLE mods_category RENAME COLUMN parent_id TO parentcat_id');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT fk_2f9b9cf5a0a4d17c FOREIGN KEY (parentcat_id) REFERENCES mods_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2f9b9cf5a0a4d17c ON mods_category (parentcat_id)');
    }
}
