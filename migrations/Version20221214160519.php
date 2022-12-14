<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214160519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE main_entity');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466810B6A72A FOREIGN KEY (main_categories_id) REFERENCES main_categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF3466810B6A72A ON categories (main_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE main_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466810B6A72A');
        $this->addSql('DROP INDEX IDX_3AF3466810B6A72A ON categories');
    }
}
