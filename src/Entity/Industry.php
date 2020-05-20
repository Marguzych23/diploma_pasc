<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IndustryRepository")
 */
class Industry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Competition", inversedBy="industry", cascade={"persist"})
     */
    private Collection $competitions;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SupportSitesIndustry", mappedBy="industry")
     */
    private Collection $supportSitesIndustries;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\EmailSubscriber", inversedBy="industry", cascade={"persist"})
     */
    private Collection $emailSubscriber;

    /**
     * Industry constructor.
     */
    public function __construct()
    {
        $this->competitions           = new ArrayCollection();
        $this->supportSitesIndustries = new ArrayCollection();
        $this->emailSubscriber        = new ArrayCollection();
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
     * @return Collection
     */
    public function getCompetitions()
    {
        return $this->competitions;
    }

    /**
     * @param Collection $competitions
     *
     * @return Industry
     */
    public function setCompetitions($competitions) : self
    {
        $this->competitions = $competitions;

        return $this;
    }


    /**
     * @param Competition $competition
     *
     * @return Industry
     */
    public function addCompetition(Competition $competition) : self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->addIndustry($this);
        }

        return $this;
    }

    /**
     * @param EmailSubscriber $emailSubscriber
     *
     * @return Industry
     */
    public function addEmailSubscriber(EmailSubscriber $emailSubscriber) : self
    {
        if (!$this->emailSubscriber->contains($emailSubscriber)) {
            $this->emailSubscriber[] = $emailSubscriber;
            $emailSubscriber->addIndustry($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSupportSitesIndustries()
    {
        return $this->supportSitesIndustries;
    }

    /**
     * @param Collection $supportSitesIndustries
     *
     * @return Industry
     */
    public function setSupportSitesIndustries($supportSitesIndustries) : Industry
    {
        $this->supportSitesIndustries = $supportSitesIndustries;

        return $this;
    }
}