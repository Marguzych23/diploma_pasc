<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520211506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email_subscriber ADD api_subscriber_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email_subscriber ADD CONSTRAINT FK_1B3A9B6D0650421 FOREIGN KEY (api_subscriber_id) REFERENCES api_subscriber (id)');
        $this->addSql('CREATE INDEX IDX_1B3A9B6D0650421 ON email_subscriber (api_subscriber_id)');

        $this->addSql("INSERT INTO api_subscriber (id, name, token, last_get_all_date, subscribe_date) VALUES
                                (1,      'Admin app', 'halamadrid', NOW(), NOW()),
                                (2,      'Grant and tender monitoring system', '123dsadfeqcr32cr21', NOW(), NOW());"
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email_subscriber DROP FOREIGN KEY FK_1B3A9B6D0650421');
        $this->addSql('DROP INDEX IDX_1B3A9B6D0650421 ON email_subscriber');
        $this->addSql('ALTER TABLE email_subscriber DROP api_subscriber_id');
    }
}
