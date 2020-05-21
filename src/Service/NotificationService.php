<?php


namespace App\Service;


use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class NotificationService
{
    protected MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
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
            ->from(new Address('science.grants.ru@gmail.com', $appName))
            ->to(new Address('recipient@example.com'))
            ->subject('New Competitions!')
            ->htmlTemplate('email/competition_notify.html.twig')
            ->context([
                'email'      => $email,
                'industries' => $industries,
            ]);

        $this->mailer->send($message);
    }

}