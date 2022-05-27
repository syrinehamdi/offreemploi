<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526134246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6388805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6388805AB2F ON contact (annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6388805AB2F');
        $this->addSql('DROP INDEX IDX_4C62E6388805AB2F ON contact');
        $this->addSql('ALTER TABLE contact DROP annonce_id');
    }
}
