<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108014056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lignes_commande (commande_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_DAAE0FCB82EA2E54 (commande_id), INDEX IDX_DAAE0FCB7294869C (article_id), PRIMARY KEY(commande_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, article_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_3170B74B82EA2E54 (commande_id), INDEX IDX_3170B74B7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_line (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, amount INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, discount INT DEFAULT NULL, item VARCHAR(255) DEFAULT NULL, item_description VARCHAR(255) DEFAULT NULL, quantity INT DEFAULT NULL, unit_code VARCHAR(255) DEFAULT NULL, unit_description VARCHAR(255) DEFAULT NULL, unit_price INT DEFAULT NULL, vatamount INT DEFAULT NULL, vatpercentage INT DEFAULT NULL, INDEX IDX_93D9398D82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lignes_commande ADD CONSTRAINT FK_DAAE0FCB82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE lignes_commande ADD CONSTRAINT FK_DAAE0FCB7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE sales_order_line ADD CONSTRAINT FK_93D9398D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lignes_commande');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE sales_order_line');
        $this->addSql('ALTER TABLE commande CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
    }
}
