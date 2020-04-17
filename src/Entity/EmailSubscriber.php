<?php


namespace App\Entity;

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
}