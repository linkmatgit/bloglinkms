<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809023317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_tag (id SERIAL NOT NULL, parent_id INT DEFAULT NULL, authors_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, color VARCHAR(6) NOT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, online BOOLEAN DEFAULT \'false\' NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EEA7C17E727ACA70 ON forum_tag (parent_id)');
        $this->addSql('CREATE INDEX IDX_EEA7C17E6DE2013A ON forum_tag (authors_id)');
        $this->addSql('ALTER TABLE forum_tag ADD CONSTRAINT FK_EEA7C17E727ACA70 FOREIGN KEY (parent_id) REFERENCES forum_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_tag ADD CONSTRAINT FK_EEA7C17E6DE2013A FOREIGN KEY (authors_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_tag DROP CONSTRAINT FK_EEA7C17E727ACA70');
        $this->addSql('DROP TABLE forum_tag');
    }
}
