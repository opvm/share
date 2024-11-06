<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102220213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_share (file_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_45852D6D93CB796C (file_id), INDEX IDX_45852D6DA76ED395 (user_id), PRIMARY KEY(file_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_share ADD CONSTRAINT FK_45852D6D93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file_share ADD CONSTRAINT FK_45852D6DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file_share DROP FOREIGN KEY FK_45852D6D93CB796C');
        $this->addSql('ALTER TABLE file_share DROP FOREIGN KEY FK_45852D6DA76ED395');
        $this->addSql('DROP TABLE file_share');
    }
}
