<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216200016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos ADD espace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enclos ADD CONSTRAINT FK_8CCECB21B6885C6C FOREIGN KEY (espace_id) REFERENCES espaces (id)');
        $this->addSql('CREATE INDEX IDX_8CCECB21B6885C6C ON enclos (espace_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enclos DROP FOREIGN KEY FK_8CCECB21B6885C6C');
        $this->addSql('DROP INDEX IDX_8CCECB21B6885C6C ON enclos');
        $this->addSql('ALTER TABLE enclos DROP espace_id');
    }
}
