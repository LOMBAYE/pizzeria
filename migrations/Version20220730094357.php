<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730094357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_taille (menu_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_A517D3E0CCD7E912 (menu_id), INDEX IDX_A517D3E0FF25611A (taille_id), PRIMARY KEY(menu_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DBF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_taille ADD CONSTRAINT FK_A517D3E0FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE menu_boisson_taille');
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1BF396750');
        $this->addSql('ALTER TABLE boisson_taille ADD taille_id INT DEFAULT NULL, ADD boisson_id INT DEFAULT NULL, DROP taille, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id)');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('CREATE INDEX IDX_E7A2EE1FF25611A ON boisson_taille (taille_id)');
        $this->addSql('CREATE INDEX IDX_E7A2EE1734B8089 ON boisson_taille (boisson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1734B8089');
        $this->addSql('CREATE TABLE menu_boisson_taille (menu_id INT NOT NULL, boisson_taille_id INT NOT NULL, INDEX IDX_17B0DBC575B6EEA7 (boisson_taille_id), INDEX IDX_17B0DBC5CCD7E912 (menu_id), PRIMARY KEY(menu_id, boisson_taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC575B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE boisson');
        $this->addSql('DROP TABLE menu_taille');
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1FF25611A');
        $this->addSql('DROP INDEX IDX_E7A2EE1FF25611A ON boisson_taille');
        $this->addSql('DROP INDEX IDX_E7A2EE1734B8089 ON boisson_taille');
        $this->addSql('ALTER TABLE boisson_taille ADD taille TINYINT(1) NOT NULL, DROP taille_id, DROP boisson_id, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1BF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
    }
}
