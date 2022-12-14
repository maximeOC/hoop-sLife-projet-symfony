<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214160932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466810B6A72A FOREIGN KEY (main_categories_id) REFERENCES main_categories (id)');
        $this->addSql('CREATE INDEX IDX_3AF3466810B6A72A ON categories (main_categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466810B6A72A');
        $this->addSql('DROP INDEX IDX_3AF3466810B6A72A ON categories');
    }
}
