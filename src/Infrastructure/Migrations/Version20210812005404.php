<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812005404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wip_tag ADD approuveby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD reason_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD statut SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD approuve SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD accept_admin BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD approuve_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD detail VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD url_of_mod VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD rejet_time INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD no_errors BOOLEAN DEFAULT \'false\' NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ADD CONSTRAINT FK_D2CFEE328EBBE9B FOREIGN KEY (approuveby_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wip_tag ADD CONSTRAINT FK_D2CFEE359BB1592 FOREIGN KEY (reason_id) REFERENCES manager_reason (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D2CFEE328EBBE9B ON wip_tag (approuveby_id)');
        $this->addSql('CREATE INDEX IDX_D2CFEE359BB1592 ON wip_tag (reason_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wip_tag DROP CONSTRAINT FK_D2CFEE328EBBE9B');
        $this->addSql('ALTER TABLE wip_tag DROP CONSTRAINT FK_D2CFEE359BB1592');
        $this->addSql('DROP INDEX IDX_D2CFEE328EBBE9B');
        $this->addSql('DROP INDEX IDX_D2CFEE359BB1592');
        $this->addSql('ALTER TABLE wip_tag DROP approuveby_id');
        $this->addSql('ALTER TABLE wip_tag DROP reason_id');
        $this->addSql('ALTER TABLE wip_tag DROP statut');
        $this->addSql('ALTER TABLE wip_tag DROP approuve');
        $this->addSql('ALTER TABLE wip_tag DROP accept_admin');
        $this->addSql('ALTER TABLE wip_tag DROP approuve_at');
        $this->addSql('ALTER TABLE wip_tag DROP detail');
        $this->addSql('ALTER TABLE wip_tag DROP url_of_mod');
        $this->addSql('ALTER TABLE wip_tag DROP rejet_time');
        $this->addSql('ALTER TABLE wip_tag DROP no_errors');
        $this->addSql('ALTER TABLE wip_tag ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE wip_tag ALTER content SET NOT NULL');
    }
}
