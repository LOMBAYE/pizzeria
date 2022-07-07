<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705205312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_taille (id INT NOT NULL, taille DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger_menu (burger_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_E42E02517CE5090 (burger_id), INDEX IDX_E42E025CCD7E912 (menu_id), PRIMARY KEY(burger_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, livraison_id INT DEFAULT NULL, is_etat TINYINT(1) DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D8E54FB25 (livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frites_portion (id INT NOT NULL, portions VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gestionnaire (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_de_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_7982ACE682EA2E54 (commande_id), INDEX IDX_7982ACE6F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, livreur_id INT DEFAULT NULL, is_etat TINYINT(1) DEFAULT NULL, INDEX IDX_A60C9F1F9F2C3FAB (zone_id), INDEX IDX_A60C9F1FF8646701 (livreur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT NOT NULL, matricule VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_boisson_taille (menu_id INT NOT NULL, boisson_taille_id INT NOT NULL, INDEX IDX_17B0DBC5CCD7E912 (menu_id), INDEX IDX_17B0DBC575B6EEA7 (boisson_taille_id), PRIMARY KEY(menu_id, boisson_taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_frites_portion (menu_id INT NOT NULL, frites_portion_id INT NOT NULL, INDEX IDX_92CC054DCCD7E912 (menu_id), INDEX IDX_92CC054DDC98719C (frites_portion_id), PRIMARY KEY(menu_id, frites_portion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_burger (id INT AUTO_INCREMENT NOT NULL, menus_id INT DEFAULT NULL, burgers_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_3CA402D514041B84 (menus_id), INDEX IDX_3CA402D51769E031 (burgers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `produit` (id INT AUTO_INCREMENT NOT NULL, gestionnaire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, image VARCHAR(255) DEFAULT NULL, is_etat TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_29A5EC276885AC1B (gestionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, is_etat TINYINT(1) NOT NULL, INDEX IDX_FEE8962D9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom_complet VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, is_enable TINYINT(1) NOT NULL, expire_at DATETIME NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, cout_livraison INT DEFAULT NULL, is_etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1BF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DBF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E02517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E025CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE frites_portion ADD CONSTRAINT FK_8B06F069BF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B20BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES `produit` (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DBF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES `produit` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson_taille ADD CONSTRAINT FK_17B0DBC575B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frites_portion ADD CONSTRAINT FK_92CC054DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_frites_portion ADD CONSTRAINT FK_92CC054DDC98719C FOREIGN KEY (frites_portion_id) REFERENCES frites_portion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D514041B84 FOREIGN KEY (menus_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D51769E031 FOREIGN KEY (burgers_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE `produit` ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_boisson_taille DROP FOREIGN KEY FK_17B0DBC575B6EEA7');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E02517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D51769E031');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE682EA2E54');
        $this->addSql('ALTER TABLE menu_frites_portion DROP FOREIGN KEY FK_92CC054DDC98719C');
        $this->addSql('ALTER TABLE `produit` DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FF8646701');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E025CCD7E912');
        $this->addSql('ALTER TABLE menu_boisson_taille DROP FOREIGN KEY FK_17B0DBC5CCD7E912');
        $this->addSql('ALTER TABLE menu_frites_portion DROP FOREIGN KEY FK_92CC054DCCD7E912');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D514041B84');
        $this->addSql('ALTER TABLE boisson_taille DROP FOREIGN KEY FK_E7A2EE1BF396750');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DBF396750');
        $this->addSql('ALTER TABLE frites_portion DROP FOREIGN KEY FK_8B06F069BF396750');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6F347EFB');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93BF396750');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE gestionnaire DROP FOREIGN KEY FK_F4461B20BF396750');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DBF396750');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F9F2C3FAB');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D9F2C3FAB');
        $this->addSql('DROP TABLE boisson_taille');
        $this->addSql('DROP TABLE burger');
        $this->addSql('DROP TABLE burger_menu');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE frites_portion');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE ligne_de_commande');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_boisson_taille');
        $this->addSql('DROP TABLE menu_frites_portion');
        $this->addSql('DROP TABLE menu_burger');
        $this->addSql('DROP TABLE `produit`');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE zone');
    }
}
