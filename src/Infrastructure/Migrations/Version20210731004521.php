<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731004521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_category ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE blog_category ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_login_ip VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_login_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blog_category ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE blog_category ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP last_login_ip');
        $this->addSql('ALTER TABLE "user" DROP last_login_at');
    }
}
