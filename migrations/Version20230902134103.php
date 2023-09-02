<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902134103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE electrovalve (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, position SMALLINT NOT NULL, is_automatic TINYINT(1) NOT NULL, INDEX IDX_99FDB4D0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE irrigation (id INT AUTO_INCREMENT NOT NULL, electrovalve_id INT NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, volume INT DEFAULT NULL, INDEX IDX_BAE1AE08A86D1584 (electrovalve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, valve_settings_id INT NOT NULL, hour_start SMALLINT NOT NULL, hour_end SMALLINT NOT NULL, day VARCHAR(50) NOT NULL, is_activated TINYINT(1) NOT NULL, INDEX IDX_5A3811FBE7000570 (valve_settings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, position SMALLINT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, unit_value VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BC8617B0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, longitude VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valve_settings (id INT AUTO_INCREMENT NOT NULL, electrovalve_id INT NOT NULL, rain_threshold DOUBLE PRECISION NOT NULL, moisture_threshold DOUBLE PRECISION NOT NULL, duration INT NOT NULL, UNIQUE INDEX UNIQ_31FE05E9A86D1584 (electrovalve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE electrovalve ADD CONSTRAINT FK_99FDB4D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE irrigation ADD CONSTRAINT FK_BAE1AE08A86D1584 FOREIGN KEY (electrovalve_id) REFERENCES electrovalve (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBE7000570 FOREIGN KEY (valve_settings_id) REFERENCES valve_settings (id)');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valve_settings ADD CONSTRAINT FK_31FE05E9A86D1584 FOREIGN KEY (electrovalve_id) REFERENCES electrovalve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE electrovalve DROP FOREIGN KEY FK_99FDB4D0A76ED395');
        $this->addSql('ALTER TABLE irrigation DROP FOREIGN KEY FK_BAE1AE08A86D1584');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBE7000570');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0A76ED395');
        $this->addSql('ALTER TABLE valve_settings DROP FOREIGN KEY FK_31FE05E9A86D1584');
        $this->addSql('DROP TABLE electrovalve');
        $this->addSql('DROP TABLE irrigation');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valve_settings');
    }
}
