<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportSiteRepository")
 */
class SupportSite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $abbreviation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $competitions_page_url;

    /**
     * @var SupportSitesIndustry[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SupportSitesIndustry", mappedBy="supportSite")
     */
    private $supportSitesIndustries;

    /**
     * SupportSite constructor.
     */
    public function __construct()
    {
        $this->supportSitesIndustries = new ArrayCollection();
    }

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
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAbbreviation() : string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation) : void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return SupportSitesIndustry[]|ArrayCollection
     */
    public function getSupportSitesIndustries()
    {
        return $this->supportSitesIndustries;
    }

    /**
     * @param SupportSitesIndustry[]|ArrayCollection $supportSitesIndustries
     */
    public function setSupportSitesIndustries($supportSitesIndustries) : void
    {
        $this->supportSitesIndustries = $supportSitesIndustries;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCompetitionsPageUrl() : string
    {
        return $this->competitions_page_url;
    }

    /**
     * @param string $competitions_page_url
     */
    public function setCompetitionsPageUrl(string $competitions_page_url) : void
    {
        $this->competitions_page_url = $competitions_page_url;
    }
}