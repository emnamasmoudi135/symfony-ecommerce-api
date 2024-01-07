<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107004632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, amount INT DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, deliver_to VARCHAR(255) DEFAULT NULL, order_id VARCHAR(255) DEFAULT NULL, order_number INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_line (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, amount INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, discount INT DEFAULT NULL, item VARCHAR(255) DEFAULT NULL, item_description VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, unit_code INT DEFAULT NULL, unit_description VARCHAR(255) DEFAULT NULL, unit_price INT DEFAULT NULL, vatamount INT DEFAULT NULL, vatpercentage INT DEFAULT NULL, INDEX IDX_93D9398D82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales_order_line ADD CONSTRAINT FK_93D9398D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sales_order_line DROP FOREIGN KEY FK_93D9398D82EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE sales_order_line');
    }
}
