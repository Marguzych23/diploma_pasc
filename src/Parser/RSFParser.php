<?php


namespace App\Parser;

use App\Entity\Competition;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class RSFParser
 * @package App\Service
 *
 * Russian Science Foundation
 */
class RSFParser extends Parser
{
    const DEADLINE_KEY   = ['приём заявок до ',];
    const INDUSTRY_KEY   = ['отраслям знаний:', '.',];
    const GRANT_SIZE_KEY = ['Размер', '10.', '.',];

    private Crawler $dataAboutCompetition;

    /**
     * @param string $data
     *
     * @return Competition
     * @throws Exception
     */
    public function parse(string $data) : Competition
    {
        $competition = new Competition();

//        Name
        $competition->setName($this->getDataAboutCompetition()->filterXPath('.//div[@class="contest-name"]')->text());

//        Deadline
        $deadline = null;

        $dateNodes = $this->getDataAboutCompetition()->filterXPath('.//div[@class="contest-date"]/span');
        foreach ($dateNodes->getIterator() as $node) {
            if (strpos($node->textContent, self::DEADLINE_KEY[0]) !== false) {
                $deadline = substr($node->textContent, strlen(self::DEADLINE_KEY[0]));
            }
        }
        $competition->setDeadline(new \DateTime($deadline));

//        Industries
        $tempIndustriesData = substr($data, strpos($data, self::INDUSTRY_KEY[0]) + strlen(self::INDUSTRY_KEY[0]));
        $tempIndustriesData = substr($tempIndustriesData, 0, strpos($tempIndustriesData, self::INDUSTRY_KEY[1]));
        $tempIndustriesData = trim(mb_strtolower($tempIndustriesData));

        foreach ($this->getSupportSiteIndustries() as $supportSiteIndustry) {
            $isMatch = false;
            foreach ($supportSiteIndustry->getKeywords() as $keyword) {
                if (strpos($tempIndustriesData, $keyword) !== false) {
                    $isMatch = true;
                    break;
                }
            }
            if ($isMatch) {
                $competition->addIndustry($supportSiteIndustry->getIndustry());
            }
        }

//        Grant size
        $tempGrantSizeData = substr($data, strpos($data, self::GRANT_SIZE_KEY[0]));
        $tempGrantSizeData = substr($tempGrantSizeData, 0, strpos($tempGrantSizeData, self::GRANT_SIZE_KEY[2]));
        $tempGrantSizeData = str_replace('<br/>', '', $tempGrantSizeData);
        $tempGrantSizeData = htmlspecialchars_decode(html_entity_decode($tempGrantSizeData));

        $competition->setGrantSize($tempGrantSizeData);


        return $competition;
    }

    /**
     * @return string|null
     */
    public function getCompetitionPath()
    {
        foreach ($this->getDataAboutCompetition()
                     ->filterXPath('.//div/ul/li/a[@class="contest-link"]')->getIterator() as $value
        ) {
            if (strpos($value->textContent, 'Конкурсная документация') !== false) {
                return $value->attributes->getNamedItem('href')->nodeValue;
            }
        }
        return null;
    }

    /**
     * @return Crawler
     */
    public function getDataAboutCompetition() : Crawler
    {
        return $this->dataAboutCompetition;
    }

    /**
     * @param Crawler $dataAboutCompetition
     */
    public function setDataAboutCompetition(Crawler $dataAboutCompetition) : void
    {
        $this->dataAboutCompetition = $dataAboutCompetition;
    }
}