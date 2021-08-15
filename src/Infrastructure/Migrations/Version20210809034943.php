<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809034943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_tag DROP CONSTRAINT fk_eea7c17e6de2013a');
        $this->addSql('DROP INDEX idx_eea7c17e6de2013a');
        $this->addSql('ALTER TABLE forum_tag RENAME COLUMN authors_id TO author_id');
        $this->addSql('ALTER TABLE forum_tag ADD CONSTRAINT FK_EEA7C17EF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EEA7C17EF675F31B ON forum_tag (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_tag DROP CONSTRAINT FK_EEA7C17EF675F31B');
        $this->addSql('DROP INDEX IDX_EEA7C17EF675F31B');
        $this->addSql('ALTER TABLE forum_tag RENAME COLUMN author_id TO authors_id');
        $this->addSql('ALTER TABLE forum_tag ADD CONSTRAINT fk_eea7c17e6de2013a FOREIGN KEY (authors_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eea7c17e6de2013a ON forum_tag (authors_id)');
    }
}
