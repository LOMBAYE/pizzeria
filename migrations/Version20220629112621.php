<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629112621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_boisson_taille (menu_id INT NOT NULL, boisson_taille_id INT NOT NULL, INDEX IDX_17B0DBC5CCD7E912 (menu_id), INDEX IDX_17B0DBC575B6EEA7 (boisson_taille_id), PRIMARY KEY(menu_id, boisson_taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_frites_portion (menu_id INT NOT NULL, frites_portion_id INT NOT NULL, INDEX IDX_92CC054DCCD7E912 (menu_id), INDEX IDX_92CC054DDC98719C (frites_portion_id), PRIMARY KEY(menu_id, frites_portion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC575B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frites_portion ADD CONSTRAINT FK_92CC054DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frites_portion ADD CONSTRAINT FK_92CC054DDC98719C FOREIGN KEY (frites_portion_id) REFERENCES frites_portion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_boisson_taille');
        $this->addSql('DROP TABLE menu_frites_portion');
    }
}
