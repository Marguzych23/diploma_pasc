<?php


namespace App\Service\Competition;

use App\Exception\CompetitionException;
use App\Exception\SupportSiteException;
use App\Parser\RFBRParser;
use App\Service\DataLoadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class RFBRService extends BaseService
{
    const ABBREVIATION = 'RFBR';

    /**
     * RFBRService constructor.
     *
     * @param RFBRParser             $rfbrParser
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(
        RFBRParser $rfbrParser,
        EntityManagerInterface $entityManagerInterface
    ) {
        parent::__construct($rfbrParser, $entityManagerInterface);
    }

    /**
     * @inheritDoc
     * @throws SupportSiteException
     * @throws CompetitionException
     */
    public function run() : array
    {
        $result = [];

        $this->initRun();
        $content = DataLoadService::loadFromURL($this->supportSite->getCompetitionsPageUrl());

        $crawler = new Crawler();
        $crawler->addHtmlContent($content, 'windows-1251');

        $competitions_urls = $crawler->filterXPath('.//table/tr/td/a');

        foreach ($competitions_urls->getIterator() as $item) {
            try {
                $this->addCompetitionByURL(
                    $this->getSiteURL()
                    . $item->attributes->getNamedItem('href')->nodeValue
                );
                $result[] = $this->getSiteURL()
                    . $item->attributes->getNamedItem('href')->nodeValue . ' is parsed';
            } catch (\Throwable $exception) {
                $result[] = ($item->attributes->getNamedItem('href')->nodeValue ?? '') . ' is NOT parsed';
            }
        }

        return $result;
    }
}