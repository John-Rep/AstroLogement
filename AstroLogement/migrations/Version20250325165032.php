<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325165032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD user_orig_id INT NOT NULL, ADD user_dest_id INT NOT NULL, DROP user_orig, DROP user_dest');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F55A69716 FOREIGN KEY (user_orig_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F218E869D FOREIGN KEY (user_dest_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F55A69716 ON message (user_orig_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F218E869D ON message (user_dest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F55A69716');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F218E869D');
        $this->addSql('DROP INDEX IDX_B6BD307F55A69716 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F218E869D ON message');
        $this->addSql('ALTER TABLE message ADD user_orig INT NOT NULL, ADD user_dest INT NOT NULL, DROP user_orig_id, DROP user_dest_id');
    }
}
