<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210807120655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE mod_id_seq CASCADE');
        $this->addSql('CREATE TABLE week_mods (id SERIAL NOT NULL, choice1_id INT DEFAULT NULL, choice2_id INT DEFAULT NULL, choice3_id INT DEFAULT NULL, choice4_id INT DEFAULT NULL, choice5_id INT DEFAULT NULL, choice6_id INT DEFAULT NULL, choice7_id INT DEFAULT NULL, choice8_id INT DEFAULT NULL, choice9_id INT DEFAULT NULL, choice10_id INT DEFAULT NULL, author_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A964FD4A272149B7 ON week_mods (choice1_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A3594E659 ON week_mods (choice2_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A8D28813C ON week_mods (choice3_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A10FFB985 ON week_mods (choice4_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4AA843DEE0 ON week_mods (choice5_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4ABAF6710E ON week_mods (choice6_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A24A166B ON week_mods (choice7_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A5A29063D ON week_mods (choice8_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4AE2956158 ON week_mods (choice9_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4A3BF24D90 ON week_mods (choice10_id)');
        $this->addSql('CREATE INDEX IDX_A964FD4AF675F31B ON week_mods (author_id)');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A272149B7 FOREIGN KEY (choice1_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A3594E659 FOREIGN KEY (choice2_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A8D28813C FOREIGN KEY (choice3_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A10FFB985 FOREIGN KEY (choice4_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4AA843DEE0 FOREIGN KEY (choice5_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4ABAF6710E FOREIGN KEY (choice6_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A24A166B FOREIGN KEY (choice7_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A5A29063D FOREIGN KEY (choice8_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4AE2956158 FOREIGN KEY (choice9_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4A3BF24D90 FOREIGN KEY (choice10_id) REFERENCES mod (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_mods ADD CONSTRAINT FK_A964FD4AF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT fk_17f45348a76ed395');
        $this->addSql('DROP INDEX idx_17f45348a76ed395');
        $this->addSql('ALTER TABLE mod DROP user_id');
        $this->addSql('ALTER TABLE mod DROP name');
        $this->addSql('ALTER TABLE mod DROP description');
        $this->addSql('ALTER TABLE mod DROP created_at');
        $this->addSql('ALTER TABLE mod DROP updated_at');
        $this->addSql('ALTER TABLE mod ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT FK_17F45348BF396750 FOREIGN KEY (id) REFERENCES content (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE mod_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE week_mods');
        $this->addSql('ALTER TABLE mod DROP CONSTRAINT FK_17F45348BF396750');
        $this->addSql('ALTER TABLE mod ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE mod ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('CREATE SEQUENCE mod_id_seq');
        $this->addSql('SELECT setval(\'mod_id_seq\', (SELECT MAX(id) FROM mod))');
        $this->addSql('ALTER TABLE mod ALTER id SET DEFAULT nextval(\'mod_id_seq\')');
        $this->addSql('ALTER TABLE mod ADD CONSTRAINT fk_17f45348a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_17f45348a76ed395 ON mod (user_id)');
    }
}
