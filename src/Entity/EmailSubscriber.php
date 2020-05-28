<?php


namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
     */
    private Collection $industries;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lastNotifyDate = null;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private bool $emailNotify = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lastEmailNotifyDate = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ApiSubscriber", inversedBy="emailSubscribers")
     */
    private ApiSubscriber $apiSubscriber;

    /**
     * EmailSubscriber constructor.
     */
    public function __construct()
    {
        $this->industries = new ArrayCollection();
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
     * @param Industry $industry
     *
     * @return EmailSubscriber
     */
    public function addIndustry(Industry $industry) : self
    {
        if (!$this->industries->contains($industry)) {
            $this->industries[] = $industry;
            $industry->addEmailSubscriber($this);
        }

        return $this;
    }

    /**
     * @return ApiSubscriber
     */
    public function getApiSubscriber() : ApiSubscriber
    {
        return $this->apiSubscriber;
    }

    /**
     * @param ApiSubscriber $apiSubscriber
     */
    public function setApiSubscriber(ApiSubscriber $apiSubscriber) : void
    {
        $this->apiSubscriber = $apiSubscriber;
    }

    /**
     * @return bool
     */
    public function isEmailNotify() : bool
    {
        return $this->emailNotify;
    }

    /**
     * @param bool $emailNotify
     */
    public function setEmailNotify(bool $emailNotify) : void
    {
        $this->emailNotify = $emailNotify;
    }

    /**
     * @return DateTime|null
     */
    public function getLastEmailNotifyDate() : ?DateTime
    {
        return $this->lastEmailNotifyDate;
    }

    /**
     * @param DateTime|null $lastEmailNotifyDate
     */
    public function setLastEmailNotifyDate(?DateTime $lastEmailNotifyDate) : void
    {
        $this->lastEmailNotifyDate = $lastEmailNotifyDate;
    }

    /**
     * @return DateTime|null
     */
    public function getLastNotifyDate() : ?DateTime
    {
        return $this->lastNotifyDate;
    }

    /**
     * @param DateTime|null $lastNotifyDate
     */
    public function setLastNotifyDate(?DateTime $lastNotifyDate) : void
    {
        $this->lastNotifyDate = $lastNotifyDate;
    }
}