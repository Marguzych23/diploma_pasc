<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417023935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE industry_email_subscriber (industry_id INT NOT NULL, email_subscriber_id INT NOT NULL, INDEX IDX_F8DA44162B19A734 (industry_id), INDEX IDX_F8DA44168A3FA205 (email_subscriber_id), PRIMARY KEY(industry_id, email_subscriber_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE industry_email_subscriber ADD CONSTRAINT FK_F8DA44162B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE industry_email_subscriber ADD CONSTRAINT FK_F8DA44168A3FA205 FOREIGN KEY (email_subscriber_id) REFERENCES email_subscriber (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE api_subscriber ADD subscribe_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE email_subscriber DROP FOREIGN KEY FK_1B3A9B62B19A734');
        $this->addSql('DROP INDEX IDX_1B3A9B62B19A734 ON email_subscriber');
        $this->addSql('ALTER TABLE email_subscriber ADD last_subscribe_date DATETIME DEFAULT NULL, DROP industry_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE industry_email_subscriber');
        $this->addSql('ALTER TABLE api_subscriber DROP subscribe_date');
        $this->addSql('ALTER TABLE email_subscriber ADD industry_id INT DEFAULT NULL, DROP last_subscribe_date');
        $this->addSql('ALTER TABLE email_subscriber ADD CONSTRAINT FK_1B3A9B62B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('CREATE INDEX IDX_1B3A9B62B19A734 ON email_subscriber (industry_id)');
    }
}
