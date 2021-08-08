<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808184024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod ADD info BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE mod ADD power VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD price VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD wheel VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD grandeur VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD champs VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod DROP info');
        $this->addSql('ALTER TABLE mod DROP power');
        $this->addSql('ALTER TABLE mod DROP price');
        $this->addSql('ALTER TABLE mod DROP wheel');
        $this->addSql('ALTER TABLE mod DROP grandeur');
        $this->addSql('ALTER TABLE mod DROP champs');
    }
}
