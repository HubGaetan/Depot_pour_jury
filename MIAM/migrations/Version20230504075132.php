<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504075132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD formation VARCHAR(20) DEFAULT NULL, ADD allergies LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD adresse_postale LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD vegan TINYINT(1) DEFAULT NULL, ADD porc TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP formation, DROP allergies, DROP adresse_postale, DROP vegan, DROP porc');
    }
}
