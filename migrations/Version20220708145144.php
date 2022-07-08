<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708145144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DBF396750');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DBF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6F347EFB');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES `produit` (id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93BF396750');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D51769E031');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D51769E031 FOREIGN KEY (burgers_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE produit CHANGE image image LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DBF396750');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6F347EFB');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93BF396750');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES produit (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D51769E031');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D51769E031 FOREIGN KEY (burgers_id) REFERENCES burger (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE `produit` CHANGE image image LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE `produit` ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
