<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportSiteIndustryRepository")
 */
class SupportSitesIndustry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $keywords;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Industry", inversedBy="supportSitesIndustries")
     */
    private Industry $industry;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SupportSite", inversedBy="supportSitesIndustries")
     */
    private SupportSite $supportSite;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return Industry
     */
    public function getIndustry() : Industry
    {
        return $this->industry;
    }

    /**
     * @param Industry $industry
     */
    public function setIndustry(Industry $industry) : void
    {
        $this->industry = $industry;
    }

    /**
     * @return SupportSite
     */
    public function getSupportSite() : SupportSite
    {
        return $this->supportSite;
    }

    /**
     * @param SupportSite $supportSite
     */
    public function setSupportSite(SupportSite $supportSite) : void
    {
        $this->supportSite = $supportSite;
    }

    /**
     * @return array
     */
    public function getKeywords() : array
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     */
    public function setKeywords(array $keywords) : void
    {
        $this->keywords = $keywords;
    }
}