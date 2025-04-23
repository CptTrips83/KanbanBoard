<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607182940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, task_entry_id INT NOT NULL, text LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_8B957886F675F31B (author_id), INDEX IDX_8B957886FAF6A30E (task_entry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_entry (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status INT NOT NULL, last_change DATETIME NOT NULL, priority INT NOT NULL, INDEX IDX_EC8586507E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B957886F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE task_comment ADD CONSTRAINT FK_8B957886FAF6A30E FOREIGN KEY (task_entry_id) REFERENCES task_entry (id)');
        $this->addSql('ALTER TABLE task_entry ADD CONSTRAINT FK_EC8586507E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B957886F675F31B');
        $this->addSql('ALTER TABLE task_comment DROP FOREIGN KEY FK_8B957886FAF6A30E');
        $this->addSql('ALTER TABLE task_entry DROP FOREIGN KEY FK_EC8586507E3C61F9');
        $this->addSql('DROP TABLE task_comment');
        $this->addSql('DROP TABLE task_entry');
    }
}
