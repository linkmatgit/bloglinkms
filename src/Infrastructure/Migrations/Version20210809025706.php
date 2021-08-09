<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809025706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_topic (id SERIAL NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content TEXT NOT NULL, solved BOOLEAN DEFAULT \'false\' NOT NULL, sticky BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, message_count INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_853478CCF675F31B ON forum_topic (author_id)');
        $this->addSql('CREATE TABLE topic_tag (forum_topic_tag INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(forum_topic_tag, tag_id))');
        $this->addSql('CREATE INDEX IDX_302AC621E634277 ON topic_tag (forum_topic_tag)');
        $this->addSql('CREATE INDEX IDX_302AC621BAD26311 ON topic_tag (tag_id)');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CCF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE topic_tag ADD CONSTRAINT FK_302AC621E634277 FOREIGN KEY (forum_topic_tag) REFERENCES forum_topic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE topic_tag ADD CONSTRAINT FK_302AC621BAD26311 FOREIGN KEY (tag_id) REFERENCES forum_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE topic_tag DROP CONSTRAINT FK_302AC621E634277');
        $this->addSql('DROP TABLE forum_topic');
        $this->addSql('DROP TABLE topic_tag');
    }
}
