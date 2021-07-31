<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731165120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod ADD approuveby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534828EBBE9B FOREIGN KEY (approuveby_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17F4534828EBBE9B ON mod (approuveby_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534828EBBE9B');
        $this->addSql('DROP INDEX IDX_17F4534828EBBE9B');
        $this->addSql('ALTER TABLE mod DROP approuveby_id');
    }
}
