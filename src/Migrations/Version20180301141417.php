<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180301141417 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494BAB96C');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP INDEX IDX_8D93D6494BAB96C ON user');
        $this->addSql('ALTER TABLE user ADD rol VARCHAR(255) NOT NULL, DROP rol_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD rol_id INT NOT NULL, DROP rol');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494BAB96C FOREIGN KEY (rol_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494BAB96C ON user (rol_id)');
    }
}
