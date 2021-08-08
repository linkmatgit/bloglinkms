<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808170958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT fk_17f4534861220ea6');
        $this->addSql('DROP INDEX idx_17f4534861220ea6');
        $this->addSql('ALTER TABLE mod RENAME COLUMN creator_id TO credit_id');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F45348CE062FF9 FOREIGN KEY (credit_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17F45348CE062FF9 ON mod (credit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F45348CE062FF9');
        $this->addSql('DROP INDEX IDX_17F45348CE062FF9');
        $this->addSql('ALTER TABLE mod RENAME COLUMN credit_id TO creator_id');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT fk_17f4534861220ea6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_17f4534861220ea6 ON mod (creator_id)');
    }
}
