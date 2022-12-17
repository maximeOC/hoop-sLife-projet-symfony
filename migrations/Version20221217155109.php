<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221217155109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5ADCD6110');
        $this->addSql('DROP INDEX IDX_B3BA5A5ADCD6110 ON products');
        $this->addSql('ALTER TABLE products DROP stock_id');
        $this->addSql('ALTER TABLE stock ADD products_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656606C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_4B3656606C8A81A9 ON stock (products_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5ADCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5ADCD6110 ON products (stock_id)');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656606C8A81A9');
        $this->addSql('DROP INDEX IDX_4B3656606C8A81A9 ON stock');
        $this->addSql('ALTER TABLE stock DROP products_id');
    }
}
