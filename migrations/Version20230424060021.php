<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424060021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_table CHANGE create_time create_time VARCHAR(100) NOT NULL, CHANGE stock_name stock_name VARCHAR(255) NOT NULL, CHANGE stock_price stock_price VARCHAR(255) NOT NULL, CHANGE last_update last_update VARCHAR(255) NOT NULL, CHANGE created_by created_by VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE Users CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE users CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stock_table CHANGE create_time create_time VARCHAR(100) DEFAULT NULL, CHANGE stock_name stock_name VARCHAR(255) DEFAULT NULL, CHANGE stock_price stock_price VARCHAR(255) DEFAULT NULL, CHANGE last_update last_update VARCHAR(255) DEFAULT NULL, CHANGE created_by created_by VARCHAR(150) DEFAULT NULL');
    }
}
