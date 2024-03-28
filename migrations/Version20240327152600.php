<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327152600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prefix_oeuvre_theme (oeuvre_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_3389B7D088194DE8 (oeuvre_id), INDEX IDX_3389B7D059027487 (theme_id), PRIMARY KEY(oeuvre_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prefix_oeuvre_theme ADD CONSTRAINT FK_3389B7D088194DE8 FOREIGN KEY (oeuvre_id) REFERENCES prefix_oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prefix_oeuvre_theme ADD CONSTRAINT FK_3389B7D059027487 FOREIGN KEY (theme_id) REFERENCES prefix_theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prefix_oeuvre_theme DROP FOREIGN KEY FK_3389B7D088194DE8');
        $this->addSql('ALTER TABLE prefix_oeuvre_theme DROP FOREIGN KEY FK_3389B7D059027487');
        $this->addSql('DROP TABLE prefix_oeuvre_theme');
    }
}
