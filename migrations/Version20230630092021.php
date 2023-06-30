<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630092021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE valve_settings (id INT AUTO_INCREMENT NOT NULL, electrovalve_id INT NOT NULL, rain_threshold DOUBLE PRECISION NOT NULL, moisture_threshold DOUBLE PRECISION NOT NULL, duration INT NOT NULL, UNIQUE INDEX UNIQ_31FE05E9A86D1584 (electrovalve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE valve_settings ADD CONSTRAINT FK_31FE05E9A86D1584 FOREIGN KEY (electrovalve_id) REFERENCES electrovalve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE valve_settings DROP FOREIGN KEY FK_31FE05E9A86D1584');
        $this->addSql('DROP TABLE valve_settings');
    }
}
