<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725130229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, id_formateur_id INT DEFAULT NULL, INDEX IDX_6EEAA67D71C15D5C (id_formation_id), INDEX IDX_6EEAA67D369CFA23 (id_formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, id_mod_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_FDCA8C9C15B99420 (id_mod_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D71C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D369CFA23 FOREIGN KEY (id_formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C15B99420 FOREIGN KEY (id_mod_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE formation ADD prix INT NOT NULL');
        $this->addSql('ALTER TABLE module ADD id_for_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628A0C6CA0 FOREIGN KEY (id_for_id) REFERENCES formation (id)');
        $this->addSql('CREATE INDEX IDX_C242628A0C6CA0 ON module (id_for_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D71C15D5C');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D369CFA23');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C15B99420');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE cours');
        $this->addSql('ALTER TABLE formation DROP prix');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628A0C6CA0');
        $this->addSql('DROP INDEX IDX_C242628A0C6CA0 ON module');
        $this->addSql('ALTER TABLE module DROP id_for_id');
    }
}
