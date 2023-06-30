<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630093348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE irrigation (id INT AUTO_INCREMENT NOT NULL, electrovalve_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, volume INT DEFAULT NULL, INDEX IDX_BAE1AE08A86D1584 (electrovalve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE08A86D1584 FOREIGN KEY (electrovalve_id) REFERENCES electrovalve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE08A86D1584');
        $this->addSql('DROP TABLE irrigation');
    }
}
