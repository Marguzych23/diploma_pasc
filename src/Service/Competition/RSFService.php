<?php


namespace App\Service\Competition;

use App\Entity\Competition;
use App\Exception\CompetitionException;
use App\Exception\SupportSiteException;
use App\Parser\RSFParser;
use App\Service\DataLoadService;
use App\Service\DataUtilService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class RSFService extends BaseService
{
    const ABBREVIATION = 'RSF';

    /**
     * RSFService constructor.
     *
     * @param RSFParser              $rsfParser
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(
        RSFParser $rsfParser,
        EntityManagerInterface $entityManagerInterface
    ) {
        parent::__construct($rsfParser, $entityManagerInterface);
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
//        all competitions
//        $content = DataLoadService::loadFromURL('https://www.rscf.ru/contests/?bxajaxid=8efca0d78ef653b6a914ba885dc536da');

        $needle  = '<div class="container">';
        $content =
            '<!DOCTYPE html><html lang="ru"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>test</title></head><body>'
            . $content
            . '</body></html>';
        $crawler = new Crawler();
        $crawler->addHtmlContent($content, 'utf-8');

        $competitionsData = $crawler->filterXPath('.//div[@id="classification-table"]'
            . '/div[@class="classification-table-row classification-parent-row contest-table-row"]'
        );

        $i = 0;
        foreach ($competitionsData->getIterator() as $DOMNode) {
            if ($i !== 0) {
                $i++;
                continue;
            }
            $nodeCrawler = new Crawler();
            $nodeCrawler->addNode($DOMNode);
            $this->parser->setDataAboutCompetition($nodeCrawler);

            try {
                $this->addCompetitionByURL(
                    $this->getSiteURL() . $this->parser->getCompetitionPath()
                );
                $result[] = $this->getSiteURL()
                    . $this->parser->getCompetitionPath() . ' is parsed';
            } catch (\Throwable $exception) {
                $result[] = ($this->parser->getCompetitionPath() ?? '') . ' is NOT parsed';
            }
        }

        return $result;
    }

    /**
     * @param string|null $url
     *
     * @return Competition
     * @throws SupportSiteException
     */
    public function parseCompetition(?string $url) : Competition
    {
        $tempHTMLFilename = TEMP_FILES . substr($url, strrpos($url, URL_SEP) + 1, -3) . 'html';

        $shell = DataUtilService::convertPDFToHTML($url, $tempHTMLFilename);
        if ($shell === null) {
            throw new SupportSiteException('', 202);
        }

        $data = DataLoadService::loadHTMLFromFile($tempHTMLFilename);

        $competition = $this->parser->parse($data);
        $competition->setUrl($url);
        $competition->setUpdateDate();

        return $competition;
    }
}