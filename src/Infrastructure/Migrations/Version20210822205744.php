<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822205744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wip_topic (id SERIAL NOT NULL, tags_id INT DEFAULT NULL, author_id INT NOT NULL, approuveby_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, completed INT DEFAULT 0 NOT NULL, statut SMALLINT DEFAULT 0 NOT NULL, approuve SMALLINT DEFAULT 0 NOT NULL, accept_admin BOOLEAN DEFAULT \'false\' NOT NULL, approuve_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, detail VARCHAR(255) DEFAULT NULL, url_of_mod VARCHAR(255) DEFAULT NULL, rejet_time INT DEFAULT NULL, no_errors BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F7BD422D8D7B4FB4 ON wip_topic (tags_id)');
        $this->addSql('CREATE INDEX IDX_F7BD422DF675F31B ON wip_topic (author_id)');
        $this->addSql('CREATE INDEX IDX_F7BD422D28EBBE9B ON wip_topic (approuveby_id)');
        $this->addSql('CREATE INDEX IDX_F7BD422D59BB1592 ON wip_topic (reason_id)');
        $this->addSql('ALTER TABLE wip_topic ADD CONSTRAINT FK_F7BD422D8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES wip_tag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wip_topic ADD CONSTRAINT FK_F7BD422DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wip_topic ADD CONSTRAINT FK_F7BD422D28EBBE9B FOREIGN KEY (approuveby_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wip_topic ADD CONSTRAINT FK_F7BD422D59BB1592 FOREIGN KEY (reason_id) REFERENCES manager_reason (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe ADD image_file VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE wip_topic');
        $this->addSql('ALTER TABLE groupe DROP image_file');
    }
}
