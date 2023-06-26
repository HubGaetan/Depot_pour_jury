<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425123259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, semaine_year VARCHAR(10) DEFAULT NULL, m1 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m2 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m3 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m4 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m5 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m6 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', m7 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s1 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s2 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s3 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s4 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s5 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s6 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', s7 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', is_open TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plats (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) DEFAULT NULL, calories DOUBLE PRECISION DEFAULT NULL, note INT DEFAULT NULL, dernier_service DATETIME DEFAULT NULL, id_cat VARCHAR(255) DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rel_menus_user (user_id INT NOT NULL, menus_id INT NOT NULL, inscription LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_DD864707A76ED395 (user_id), INDEX IDX_DD86470714041B84 (menus_id), PRIMARY KEY(user_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, status VARCHAR(10) DEFAULT NULL, regime LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rel_menus_user ADD CONSTRAINT FK_DD864707A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rel_menus_user ADD CONSTRAINT FK_DD86470714041B84 FOREIGN KEY (menus_id) REFERENCES menus (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rel_menus_user DROP FOREIGN KEY FK_DD864707A76ED395');
        $this->addSql('ALTER TABLE rel_menus_user DROP FOREIGN KEY FK_DD86470714041B84');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE plats');
        $this->addSql('DROP TABLE rel_menus_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
