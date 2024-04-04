<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329111101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prefix_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prefix_oeuvre ADD size_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prefix_oeuvre ADD CONSTRAINT FK_5E5FC0F9498DA827 FOREIGN KEY (size_id) REFERENCES prefix_size (id)');
        $this->addSql('CREATE INDEX IDX_5E5FC0F9498DA827 ON prefix_oeuvre (size_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prefix_oeuvre DROP FOREIGN KEY FK_5E5FC0F9498DA827');
        $this->addSql('DROP TABLE prefix_size');
        $this->addSql('DROP INDEX IDX_5E5FC0F9498DA827 ON prefix_oeuvre');
        $this->addSql('ALTER TABLE prefix_oeuvre DROP size_id');
    }
}
