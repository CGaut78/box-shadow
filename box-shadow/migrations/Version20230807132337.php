<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807132337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE suivre (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT NOT NULL, id_eleve_id INT NOT NULL, INDEX IDX_3BC593BB71C15D5C (id_formation_id), INDEX IDX_3BC593BB5AB72B27 (id_eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suivre ADD CONSTRAINT FK_3BC593BB71C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE suivre ADD CONSTRAINT FK_3BC593BB5AB72B27 FOREIGN KEY (id_eleve_id) REFERENCES eleve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivre DROP FOREIGN KEY FK_3BC593BB71C15D5C');
        $this->addSql('ALTER TABLE suivre DROP FOREIGN KEY FK_3BC593BB5AB72B27');
        $this->addSql('DROP TABLE suivre');
    }
}
