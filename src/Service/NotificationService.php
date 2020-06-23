<?php


namespace App\Service;


use App\Entity\Competition;
use App\Entity\EmailSubscriber;
use App\Entity\Industry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class NotificationService
{
    protected MailerInterface        $mailer;
    protected EntityManagerInterface $entityManager;

    /**
     * NotificationService constructor.
     *
     * @param MailerInterface        $mailer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer        = $mailer;
        $this->entityManager = $entityManager;
    }


    /**
     *
     * @throws TransportExceptionInterface
     */
    public function notifyUsers()
    {
        $currentDate = new \DateTime();

        /** @var EmailSubscriber $emailSubscriber */
        foreach (
            $this->entityManager
                ->getRepository(EmailSubscriber::class)
                ->findBy([
                    'emailNotify' => true,
                ])
            as $emailSubscriber
        ) {
            $industryArray = [];
            /** @var Industry $industry */
            foreach ($emailSubscriber->getIndustries() as $industry) {
                $industryArray[$industry->getId()]['name'] = $industry->getName();
                /** @var Competition $competition */
                foreach ($industry->getCompetitions() as $competition) {
                    if (($emailSubscriber->getLastEmailNotifyDate() !== null
                            && $competition->getUpdateDate() > $emailSubscriber->getLastEmailNotifyDate())
                        || ($emailSubscriber->getLastEmailNotifyDate() === null
                            && $competition->getDeadline() > $currentDate)
                    ) {
                        $industryArray[$industry->getId()]['competitions'][] = [
                            'name' => $competition->getName(),
                            'url'  => $competition->getUrl(),
                        ];
                    }
                }

            }

            $this->notifyByMailer(
                $emailSubscriber->getEmail(),
                $emailSubscriber->getApiSubscriber()->getName(),
                $industryArray
            );

            $emailSubscriber->setLastEmailNotifyDate($currentDate);
            $this->entityManager->persist($emailSubscriber);
            $this->entityManager->flush();
        }
    }

    /**
     * @param string $email
     * @param string $appName
     * @param array  $industries
     *
     * @throws TransportExceptionInterface
     */
    public function notifyByMailer(string $email, string $appName, array $industries)
    {
        $message = (new TemplatedEmail())
            ->from(new Address($_ENV['GMAIL_USER'], $appName))
            ->to(new Address($email))
            ->subject('New Competitions!')
            ->htmlTemplate('email/competition_notify.html.twig')
            ->context([
                'user_email'      => $email,
                'industries' => $industries,
            ]);

        $this->mailer->send($message);
    }

}