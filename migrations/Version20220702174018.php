<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220702174018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quartier_zone');
        $this->addSql('ALTER TABLE quartier ADD zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_FEE8962D9F2C3FAB ON quartier (zone_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quartier_zone (quartier_id INT NOT NULL, zone_id INT NOT NULL, INDEX IDX_717AA8FADF1E57AB (quartier_id), INDEX IDX_717AA8FA9F2C3FAB (zone_id), PRIMARY KEY(quartier_id, zone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quartier_zone ADD CONSTRAINT FK_717AA8FADF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quartier_zone ADD CONSTRAINT FK_717AA8FA9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D9F2C3FAB');
        $this->addSql('DROP INDEX IDX_FEE8962D9F2C3FAB ON quartier');
        $this->addSql('ALTER TABLE quartier DROP zone_id');
    }
}
