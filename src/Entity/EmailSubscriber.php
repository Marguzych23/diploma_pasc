<?php


namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailSubscriberRepository")
 */
class EmailSubscriber
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
    private string $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Industry", mappedBy="emailSubscriber", cascade={"persist"})
     * @ORM\JoinTable(name="email_subscribers_industries")
     */
    private Collection $industries;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lastSubscribeDate = null;

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
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    /**
     * @return Collection
     */
    public function getIndustries() : Collection
    {
        return $this->industries;
    }

    /**
     * @param Collection $industries
     */
    public function setIndustries(Collection $industries) : void
    {
        $this->industries = $industries;
    }

    /**
     * @return DateTime|null
     */
    public function getLastSubscribeDate() : ?DateTime
    {
        return $this->lastSubscribeDate;
    }

    /**
     * @param DateTime|null $lastSubscribeDate
     */
    public function setLastSubscribeDate(?DateTime $lastSubscribeDate) : void
    {
        $this->lastSubscribeDate = $lastSubscribeDate;
    }
}