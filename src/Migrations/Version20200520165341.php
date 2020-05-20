<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520165341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE api_subscriber (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, last_get_all_date DATETIME DEFAULT NULL, subscribe_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, deadline DATETIME DEFAULT NULL, grant_size VARCHAR(512) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, update_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_subscriber (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, last_subscribe_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE industry (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE industry_competition (industry_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_8769D6E72B19A734 (industry_id), INDEX IDX_8769D6E77B39D312 (competition_id), PRIMARY KEY(industry_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE industry_email_subscriber (industry_id INT NOT NULL, email_subscriber_id INT NOT NULL, INDEX IDX_F8DA44162B19A734 (industry_id), INDEX IDX_F8DA44168A3FA205 (email_subscriber_id), PRIMARY KEY(industry_id, email_subscriber_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, competitions_page_url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B1559FB75E237E06 (name), UNIQUE INDEX UNIQ_B1559FB7BCF3411D (abbreviation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_sites_industry (id INT AUTO_INCREMENT NOT NULL, industry_id INT DEFAULT NULL, support_site_id INT DEFAULT NULL, keywords LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_1905CF9A2B19A734 (industry_id), INDEX IDX_1905CF9A4B881EBA (support_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE industry_competition ADD CONSTRAINT FK_8769D6E72B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE industry_competition ADD CONSTRAINT FK_8769D6E77B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE industry_email_subscriber ADD CONSTRAINT FK_F8DA44162B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE industry_email_subscriber ADD CONSTRAINT FK_F8DA44168A3FA205 FOREIGN KEY (email_subscriber_id) REFERENCES email_subscriber (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE support_sites_industry ADD CONSTRAINT FK_1905CF9A2B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('ALTER TABLE support_sites_industry ADD CONSTRAINT FK_1905CF9A4B881EBA FOREIGN KEY (support_site_id) REFERENCES support_site (id)');


        $this->addSql("INSERT INTO industry (id, name) VALUES
                                (1,      'Математика'),
                                (2,      'Информационные технологии и вычислительные системы'),
                                (3,      'Физика и астрономия'),
                                (4,      'Химия и науки о материалах'),
                                (5,      'Биология'),
                                (6,      'Медицина'),
                                (7,      'Науки о Земле'),
                                (8,      'Лингвистика и культурология'),
                                (9,      'История, археология, этнология, антропология'),
                                (10,     'Философия, политология, социология, правоведение, история науки и техники, науковедение'),
                                (11,     'Психология, фундаментальные проблемы образования, социальные проблемы здоровья и экологии человека'),
                                (12,     'Глобальные проблемы и международные отношения'),
                                (13,     'Инженерные науки'),
                                (14,     'Сельскохозяйственные науки'),
                                (15,     'Экономика');"
        );
        $this->addSql("INSERT INTO support_site (id, name, abbreviation, url, competitions_page_url) VALUES
                                (1,  'Российский Фонд Фундаментальных Исследований',  'RFBR',  'https://www.rfbr.ru',  'https://www.rfbr.ru/rffi/ru/contest_search?CONTEST_STATUS_ID=1&CONTEST_TYPE=-1&CONTEST_YEAR=-1');"
        );
        $this->addSql('INSERT INTO `support_sites_industry` (`id`, `industry_id`, `support_site_id`, `keywords`) VALUES
                                (1,	    1,	1,	\'a:1:{i:0;s:10:"матем";}\'),
                                (2,	    2,	1,	\'a:4:{i:0;s:8:"техн";i:1;s:12:"информ";i:2;s:18:"компьютер";i:3;s:12:"вычисл";}\'),
                                (3,	    3,	1,	\'a:3:{i:0;s:8:"косм";i:1;s:16:"астроном";i:2;s:8:"физи";}\'),
                                (4,	    4,	1,	\'a:3:{i:0;s:8:"хими";i:1;s:8:"нефт";i:2;s:6:"газ";}\'),
                                (5,	    5,	1,	\'a:1:{i:0;s:6:"био";}\'),
                                (6,	    6,	1,	\'a:2:{i:0;s:12:"биоинф";i:1;s:14:"медицин";}\'),
                                (7,	    7,	1,	\'a:1:{i:0;s:8:"земл";}\'),
                                (8,	    8,	1,	\'a:4:{i:0;s:14:"филолог";i:1;s:16:"искусств";i:2;s:16:"лингвист";i:3;s:14:"культур";}\'),
                                (9, 	9,	1,	\'a:4:{i:0;s:12:"исторг";i:1;s:8:"архе";i:2;s:8:"этно";i:3;s:12:"антроп";}\'),
                                (10,	10,	1,	\'a:4:{i:0;s:10:"право";i:1;s:10:"социо";i:2;s:10:"полит";i:3;s:14:"филосов";}\'),
                                (11,	11,	1,	\'a:2:{i:0;s:8:"псих";i:1;s:20:"образовани";}\'),
                                (12,	12,	1,	\'a:2:{i:0;s:10:"народ";i:1;s:12:"глобал";}\'),
                                (13,	13,	1,	\'a:2:{i:0;s:14:"инженер";i:1;s:10:"механ";}\'),
                                (14,	14,	1,	\'a:2:{i:0;s:14:"сельско";i:1;s:16:"хозяйств";}\'),
                                (15,	15,	1,	\'a:1:{i:0;s:12:"эконом";}\');'
        );

        $this->addSql("INSERT INTO support_site (id, name, abbreviation, url, competitions_page_url) VALUES
                                (2,  'Российский Научный Фонд',  'RSF',  'https://www.rscf.ru',  'https://www.rscf.ru/contests/?status=acceptance&bxajaxid=8efca0d78ef653b6a914ba885dc536da');"
        );

        $this->addSql('INSERT INTO `support_sites_industry` (`id`, `industry_id`, `support_site_id`, `keywords`) VALUES
                                (16,	1,	2,	\'a:1:{i:0;s:10:"матем";}\'),
                                (17,	2,	2,	\'a:2:{i:0;s:8:"техн";i:1;s:12:"информ";}\'),
                                (18,	3,	2,	\'a:3:{i:0;s:8:"косм";i:1;s:16:"астроном";i:2;s:10:"физик";}\'),
                                (19,	4,	2,	\'a:1:{i:0;s:8:"хими";}\'),
                                (20,	5,	2,	\'a:1:{i:0;s:6:"био";}\'),
                                (21,	6,	2,	\'a:1:{i:0;s:14:"медицин";}\'),
                                (22,	7,	2,	\'a:1:{i:0;s:8:"земл";}\'),
                                (23,	8,	2,	\'a:2:{i:0;s:14:"гуманит";i:1;s:10:"социо";}\'),
                                (24, 	9,	2,	\'a:2:{i:0;s:14:"гуманит";i:1;s:10:"социо";}\'),
                                (25,	10,	2,	\'a:2:{i:0;s:14:"гуманит";i:1;s:10:"социо";}\'),
                                (26,	11,	2,	\'a:2:{i:0;s:14:"гуманит";i:1;s:10:"социо";}\'),
                                (27,	12,	2,	\'a:2:{i:0;s:14:"гуманит";i:1;s:10:"социо";}\'),
                                (28,	13,	2,	\'a:1:{i:0;s:14:"инженер";}\'),
                                (29,	14,	2,	\'a:2:{i:0;s:14:"сельско";i:1;s:16:"хозяйств";}\'),
                                (30,	15,	2,	\'a:1:{i:0;s:14:"экономи";}\');'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE industry_competition DROP FOREIGN KEY FK_8769D6E77B39D312');
        $this->addSql('ALTER TABLE industry_email_subscriber DROP FOREIGN KEY FK_F8DA44168A3FA205');
        $this->addSql('ALTER TABLE industry_competition DROP FOREIGN KEY FK_8769D6E72B19A734');
        $this->addSql('ALTER TABLE industry_email_subscriber DROP FOREIGN KEY FK_F8DA44162B19A734');
        $this->addSql('ALTER TABLE support_sites_industry DROP FOREIGN KEY FK_1905CF9A2B19A734');
        $this->addSql('ALTER TABLE support_sites_industry DROP FOREIGN KEY FK_1905CF9A4B881EBA');
        $this->addSql('DROP TABLE api_subscriber');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE email_subscriber');
        $this->addSql('DROP TABLE industry');
        $this->addSql('DROP TABLE industry_competition');
        $this->addSql('DROP TABLE industry_email_subscriber');
        $this->addSql('DROP TABLE support_site');
        $this->addSql('DROP TABLE support_sites_industry');
    }
}
