<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327122049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prefix_theme (id INT AUTO_INCREMENT NOT NULL, urbain VARCHAR(255) DEFAULT NULL, portrait VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prefix_theme_oeuvre (theme_id INT NOT NULL, oeuvre_id INT NOT NULL, INDEX IDX_DE72092559027487 (theme_id), INDEX IDX_DE72092588194DE8 (oeuvre_id), PRIMARY KEY(theme_id, oeuvre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prefix_theme_oeuvre ADD CONSTRAINT FK_DE72092559027487 FOREIGN KEY (theme_id) REFERENCES prefix_theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prefix_theme_oeuvre ADD CONSTRAINT FK_DE72092588194DE8 FOREIGN KEY (oeuvre_id) REFERENCES prefix_oeuvre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prefix_theme_oeuvre DROP FOREIGN KEY FK_DE72092559027487');
        $this->addSql('ALTER TABLE prefix_theme_oeuvre DROP FOREIGN KEY FK_DE72092588194DE8');
        $this->addSql('DROP TABLE prefix_theme');
        $this->addSql('DROP TABLE prefix_theme_oeuvre');
    }
}
