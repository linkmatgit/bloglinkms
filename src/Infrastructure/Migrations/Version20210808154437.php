<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808154437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_category (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, color VARCHAR(255) DEFAULT \'#000000\' NOT NULL, online BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_72113DE6A76ED395 ON blog_category (user_id)');
        $this->addSql('CREATE TABLE blog_posts (id INT NOT NULL, category_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_78B2F93212469DE2 ON blog_posts (category_id)');
        $this->addSql('CREATE TABLE content (id SERIAL NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, online BOOLEAN DEFAULT \'false\' NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEC530A9A76ED395 ON content (user_id)');
        $this->addSql('CREATE TABLE "group" (id SERIAL NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DC044C5F675F31B ON "group" (author_id)');
        $this->addSql('CREATE TABLE manager_reason (id SERIAL NOT NULL, name VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, key VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD9D8E7E8A90ABA9 ON manager_reason (key)');
        $this->addSql('CREATE TABLE mod (id INT NOT NULL, creator_id INT DEFAULT NULL, category_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, approuveby_id INT DEFAULT NULL, reason_id INT DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, console BOOLEAN DEFAULT \'false\' NOT NULL, statut SMALLINT DEFAULT 0 NOT NULL, approuve SMALLINT DEFAULT 0 NOT NULL, accept_admin BOOLEAN DEFAULT \'false\' NOT NULL, approuve_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, detail VARCHAR(255) DEFAULT NULL, url_of_mod VARCHAR(255) DEFAULT NULL, rejet_time INT DEFAULT NULL, no_errors BOOLEAN DEFAULT \'false\' NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17F4534861220EA6 ON mod (creator_id)');
        $this->addSql('CREATE INDEX IDX_17F4534812469DE2 ON mod (category_id)');
        $this->addSql('CREATE INDEX IDX_17F4534844F5D008 ON mod (brand_id)');
        $this->addSql('CREATE INDEX IDX_17F4534828EBBE9B ON mod (approuveby_id)');
        $this->addSql('CREATE INDEX IDX_17F4534859BB1592 ON mod (reason_id)');
        $this->addSql('CREATE TABLE mods_brand (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, online BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAC07953A76ED395 ON mods_brand (user_id)');
        $this->addSql('CREATE TABLE mods_category (id SERIAL NOT NULL, author_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, position INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, online BOOLEAN DEFAULT \'false\' NOT NULL, mods_count INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F9B9CF5F675F31B ON mods_category (author_id)');
        $this->addSql('CREATE INDEX IDX_2F9B9CF5727ACA70 ON mods_category (parent_id)');
        $this->addSql('CREATE TABLE notification (id SERIAL NOT NULL, user_id INT DEFAULT NULL, message TEXT NOT NULL, url VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, channel VARCHAR(255) DEFAULT NULL, target VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF5476CAA76ED395 ON notification (user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, last_login_ip VARCHAR(180) DEFAULT NULL, last_login_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(250) DEFAULT NULL, banned BOOLEAN DEFAULT \'false\' NOT NULL, banned_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, notifications_read_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON "user" (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE wip_tag (id SERIAL NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, completed INT DEFAULT 0 NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2CFEE3F675F31B ON wip_tag (author_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE blog_category ADD CONSTRAINT FK_72113DE6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_posts ADD CONSTRAINT FK_78B2F93212469DE2 FOREIGN KEY (category_id) REFERENCES blog_category (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_posts ADD CONSTRAINT FK_78B2F932BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT FK_6DC044C5F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534861220EA6 FOREIGN KEY (creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534812469DE2 FOREIGN KEY (category_id) REFERENCES mods_category (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534844F5D008 FOREIGN KEY (brand_id) REFERENCES mods_brand (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534828EBBE9B FOREIGN KEY (approuveby_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F4534859BB1592 FOREIGN KEY (reason_id) REFERENCES manager_reason (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F45348BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mods_brand ADD CONSTRAINT FK_EAC07953A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT FK_2F9B9CF5F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mods_category ADD CONSTRAINT FK_2F9B9CF5727ACA70 FOREIGN KEY (parent_id) REFERENCES mods_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wip_tag ADD CONSTRAINT FK_D2CFEE3F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_posts DROP CONSTRAINT FK_78B2F93212469DE2');
        $this->addSql('ALTER TABLE blog_posts DROP CONSTRAINT FK_78B2F932BF396750');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F45348BF396750');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534859BB1592');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534844F5D008');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534812469DE2');
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT FK_2F9B9CF5727ACA70');
        $this->addSql('ALTER TABLE blog_category DROP CONSTRAINT FK_72113DE6A76ED395');
        $this->addSql('ALTER TABLE content DROP CONSTRAINT FK_FEC530A9A76ED395');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT FK_6DC044C5F675F31B');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534861220EA6');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F4534828EBBE9B');
        $this->addSql('ALTER TABLE mods_brand DROP CONSTRAINT FK_EAC07953A76ED395');
        $this->addSql('ALTER TABLE mods_category DROP CONSTRAINT FK_2F9B9CF5F675F31B');
        $this->addSql('ALTER TABLE notification DROP CONSTRAINT FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE wip_tag DROP CONSTRAINT FK_D2CFEE3F675F31B');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE blog_posts');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE manager_reason');
        $this->addSql('DROP TABLE mod');
        $this->addSql('DROP TABLE mods_brand');
        $this->addSql('DROP TABLE mods_category');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE wip_tag');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
