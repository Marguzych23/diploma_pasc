<?php


namespace App\Parser;

use App\Entity\Competition;
use App\Exception\CompetitionException;
use DateTime;
use Exception;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class RFBRParser
 * @package App\Service
 *
 * Russian Foundation for Basic Research
 */
class RFBRParser extends Parser
{
    const DEADLINE_KEY    = [
        'Заявки принимаются до:',
        'Дата и время окончания подачи заявок:',
    ];
    const GRANT_SIZE_KEYS = [
        'Максимальный объем финансирования проекта',
        'Максимальный размер гранта',
    ];
    const INDUSTRIES_KEYS = ['(', ')'];

    protected static array $filters_for_search_data = [
        './/div[@id="selectable-content"]/p/strong',
        './/div[@id="selectable-content"]/p',
    ];

    /**
     * @param string $data
     *
     * @return Competition
     * @throws Exception
     */
    public function parse(string $data) : Competition
    {
        $competition = new Competition();

        $crawler = new Crawler();
        $crawler->addHtmlContent($data, 'windows-1251');

//        Name
        $competition->setName($crawler->filterXPath('.//h1[@class="title js-print-title title"]')->text());

        $deadline  = null;
        $grantSize = null;

//        Search data
        $tempIndustries = [];
        try {
            $industriesContent = $crawler->filterXPath('.//div[@id="selectable-content"]/ul/li');

            foreach ($industriesContent->getIterator() as $item) {
                $tempIndustries[] = $item->textContent;
            }
        } catch (InvalidArgumentException $exception) {
        }

        $deadline_sfc = $crawler->filterXPath('.//div/p[@class="sfc"]');
        if ($deadline_sfc->getIterator()->count() !== 0) {
            foreach ($deadline_sfc->getIterator() as $node) {
                if (strpos($node->textContent, self::DEADLINE_KEY[0]) !== false) {
                    $deadline = trim(
                        substr(
                            $node->textContent,
                            strlen(self::DEADLINE_KEY[0]) + 1, 16
                        )
                    );
                }
            }
        }
        foreach (self::$filters_for_search_data as $filter_for_search_data) {
            $selectableContent = $crawler->filterXPath($filter_for_search_data);
            foreach ($selectableContent->getIterator() as $item) {
                if ($deadline === null
                    && strpos($item->textContent, self::DEADLINE_KEY[1]) !== false
                ) {
                    $deadline = substr(
                        trim(str_replace($item->textContent, '', $item->parentNode->textContent)),
                        0, 16
                    );
                } elseif ($grantSize === null
                    && $this->isInArray($item->textContent, self::GRANT_SIZE_KEYS)
                ) {
                    $childText = $item->textContent . (strpos($item->textContent, ':') !== false ? '' : ':');
                    $grantSize = trim(str_replace($childText, '', $item->parentNode->textContent));
                    if (empty($grantSize)) {
                        foreach (self::GRANT_SIZE_KEYS as $key) {
                            if (strpos($item->textContent, $key) !== false) {
                                $grantSize = trim(str_replace($key . ':', '', $item->textContent));
                                break;
                            }
                        }
                    }
                } elseif ($this->isInArray($item->textContent, self::INDUSTRIES_KEYS, true)) {  // industry
                    $tempIndustries[] = $item->textContent;
                } elseif ($deadline !== null && $grantSize !== null && !empty($tempIndustries)) {
                    break;
                }
            }
        }
//        Deadline set
        try {
            $competition->setDeadline(new DateTime($deadline));
        } catch (Exception $e) {
        }
//        Grant size set
        $competition->setGrantSize($grantSize);
//        Industries set
        if (empty($tempIndustries)) {
            throw new CompetitionException();
        } else {
            foreach ($tempIndustries as $tempIndustry) {
                foreach ($this->getSupportSiteIndustries() as $supportSiteIndustry) {
                    $isMatch = false;
                    foreach ($supportSiteIndustry->getKeywords() as $keyword) {
                        if (strpos($tempIndustry, $keyword) !== false) {
                            $isMatch = true;
                            break;
                        }
                    }
                    if ($isMatch) {
                        $competition->addIndustry($supportSiteIndustry->getIndustry());
                    }
                }
            }
        }

        return $competition;
    }

    /**
     * @param string $data
     *
     * @param array  $keys
     * @param bool   $fullMatch
     *
     * @return bool
     */
    protected function isInArray(string $data, array $keys = [], bool $fullMatch = false)
    {
        foreach ($keys as $key) {
            if (strpos($data, $key) !== false) {
                if (!$fullMatch) {
                    return true;
                }
            } elseif ($fullMatch) {
                return false;
            }
        }

        return $fullMatch;
    }
}