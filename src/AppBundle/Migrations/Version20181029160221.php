<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181029160221 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, path CLOB NOT NULL, mime VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, "key" VARCHAR(36) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F36108A90ABA9 ON file ("key")');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, avatar_id INTEGER DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, zip VARCHAR(10) NOT NULL, birthday DATE NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) DEFAULT \'\' NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT \'\' NOT NULL, country VARCHAR(2) DEFAULT \'\' NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E63886383B10 ON contact (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE contact');
    }
}
