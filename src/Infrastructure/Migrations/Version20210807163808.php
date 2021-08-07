<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210807163808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_posts ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT fk_17f45348ff1c8a47');
        $this->addSql('DROP INDEX idx_17f45348ff1c8a47');
        $this->addSql('ALTER TABLE mod ADD reason_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mod DROP reason_key');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534859BB1592 FOREIGN KEY (reason_id) REFERENCES manager_reason (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17F4534859BB1592 ON mod (reason_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blog_posts DROP slug');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534859BB1592');
        $this->addSql('DROP INDEX IDX_17F4534859BB1592');
        $this->addSql('ALTER TABLE mod ADD reason_key VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod DROP reason_id');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT fk_17f45348ff1c8a47 FOREIGN KEY (reason_key) REFERENCES manager_reason (key) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_17f45348ff1c8a47 ON mod (reason_key)');
    }
}
