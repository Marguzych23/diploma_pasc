<?php


namespace App\Parser;


use App\Entity\Competition;
use App\Entity\SupportSitesIndustry;

abstract class Parser
{
    /** @var array|SupportSitesIndustry[] */
    protected ?array $supportSiteIndustries = null;

    /**
     * @param string $data
     *
     * @return Competition
     */
    abstract public function parse(string $data) : Competition;

    /**
     * @return SupportSitesIndustry[]|array
     */
    public function getSupportSiteIndustries()
    {
        return $this->supportSiteIndustries;
    }

    /**
     * @param SupportSitesIndustry[]|array $supportSiteIndustries
     */
    public function setSupportSiteIndustries($supportSiteIndustries) : void
    {
        $this->supportSiteIndustries = $supportSiteIndustries;
    }
}