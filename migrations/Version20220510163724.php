<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510163724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE description ADD CONSTRAINT FK_6DE44026F347EFB FOREIGN KEY (produit_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_6DE44026F347EFB ON description (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description DROP FOREIGN KEY FK_6DE44026F347EFB');
        $this->addSql('DROP INDEX IDX_6DE44026F347EFB ON description');
        $this->addSql('ALTER TABLE description DROP produit_id');
    }
}
