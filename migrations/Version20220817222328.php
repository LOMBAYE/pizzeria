<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220817222328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_frite (id INT AUTO_INCREMENT NOT NULL, frite_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantite INT DEFAULT NULL, INDEX IDX_B147E70ABE00B4D9 (frite_id), INDEX IDX_B147E70ACCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ABE00B4D9 FOREIGN KEY (frite_id) REFERENCES frites_portion (id)');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_frite');
    }
}
