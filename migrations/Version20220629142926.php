<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629142926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE140D9D0AA');
        $this->addSql('DROP TABLE complement');
        $this->addSql('DROP INDEX IDX_E7A2EE140D9D0AA ON boisson_taille');
        $this->addSql('ALTER TABLE boisson_taille DROP complement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complement (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boisson_taille ADD complement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE140D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_E7A2EE140D9D0AA ON boisson_taille (complement_id)');
    }
}
