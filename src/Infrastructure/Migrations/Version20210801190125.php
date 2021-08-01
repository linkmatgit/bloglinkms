<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801190125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod ADD brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534844F5D008 FOREIGN KEY (brand_id) REFERENCES mods_brand (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17F4534844F5D008 ON mod (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534844F5D008');
        $this->addSql('DROP INDEX IDX_17F4534844F5D008');
        $this->addSql('ALTER TABLE mod DROP brand_id');
    }
}
