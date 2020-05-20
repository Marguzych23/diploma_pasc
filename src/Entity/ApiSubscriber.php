<?php


namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApiSubscriberRepository")
 */
class ApiSubscriber
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
     * @ORM\Column(type="string", length=255)
     */
    private string $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lastGetAllDate = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $subscribeDate = null;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\EmailSubscriber", mappedBy="apiSubscriber")
     */
    private Collection $emailSubscribers;

    /**
     * ApiSubscriber constructor.
     */
    public function __construct()
    {
        $this->emailSubscribers = new ArrayCollection();
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
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token) : void
    {
        $this->token = $token;
    }

    /**
     * @return DateTime|null
     */
    public function getLastGetAllDate() : ?DateTime
    {
        return $this->lastGetAllDate;
    }

    /**
     * @param DateTime|null $lastGetAllDate
     */
    public function setLastGetAllDate(?DateTime $lastGetAllDate) : void
    {
        $this->lastGetAllDate = $lastGetAllDate;
    }

    /**
     * @return DateTime|null
     */
    public function getSubscribeDate() : ?DateTime
    {
        return $this->subscribeDate;
    }

    /**
     * @param DateTime|null $subscribeDate
     */
    public function setSubscribeDate(?DateTime $subscribeDate) : void
    {
        $this->subscribeDate = $subscribeDate;
    }

    /**
     * @return Collection
     */
    public function getEmailSubscribers() : Collection
    {
        return $this->emailSubscribers;
    }

    /**
     * @param Collection $emailSubscribers
     */
    public function setEmailSubscribers(Collection $emailSubscribers) : void
    {
        $this->emailSubscribers = $emailSubscribers;
    }
}