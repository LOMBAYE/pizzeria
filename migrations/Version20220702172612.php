<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220702172612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quartier_zone (quartier_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_717AA8FADF1E57AB (quartier_id), INDEX IDX_717AA8FA9F2C3FAB (zone_id), PRIMARY KEY(quartier_id, zone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quartier_zone ADD CONSTRAINT FK_717AA8FADF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quartier_zone ADD CONSTRAINT FK_717AA8FA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quartier_zone');
    }
}
