<?php


namespace App\Service\Competition;

use App\Exception\CompetitionException;
use App\Exception\SupportSiteException;
use App\Parser\Parser;
use App\Service\DataLoadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class RFBRService extends BaseService
{
    const ABBREVIATION = 'RFBR';

    /**
     * RFBRService constructor.
     *
     * @param Parser                 $rfbrParser
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(
        Parser $rfbrParser,
        EntityManagerInterface $entityManagerInterface
    ) {
        parent::__construct($rfbrParser, $entityManagerInterface);
    }

    /**
     * @inheritDoc
     * @throws SupportSiteException
     * @throws CompetitionException
     */
    public function run() : void
    {
        $this->initRun();
        $content = DataLoadService::loadFromURL($this->supportSite->getCompetitionsPageUrl());

        $crawler = new Crawler();
        $crawler->addHtmlContent($content, 'windows-1251');

        $competitions_urls = $crawler->filterXPath('.//table/tr/td/a');

        $site_url = $this->supportSite->getUrl();
        if (substr($site_url, -1) === URL_SEP) {
            $site_url = substr($site_url, 0, strlen($site_url) - 1);
        }

        foreach ($competitions_urls->getIterator() as $item) {
            $this->addCompetitionByURL(
                $site_url
                . $item->attributes->getNamedItem('href')->nodeValue
            );
        }
    }
}