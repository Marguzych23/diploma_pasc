<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519211721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
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

    }
}
