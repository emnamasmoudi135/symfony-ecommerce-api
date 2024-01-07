<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107020124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD item VARCHAR(255) NOT NULL, ADD item_description VARCHAR(255) NOT NULL, ADD unit_code VARCHAR(255) DEFAULT NULL, ADD unit_description VARCHAR(255) DEFAULT NULL, ADD unit_price NUMERIC(10, 2) DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE article DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE article DROP item, DROP item_description, DROP unit_code, DROP unit_description, DROP unit_price, CHANGE id id INT NOT NULL');
    }
}
