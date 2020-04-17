<?php


namespace App\Service;


use Doctrine\Common\Collections\Collection;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationService
{
    protected Swift_Mailer $mailer;
    protected $template;

    public function __construct(Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->template = $container->get('templating');
    }

    public function notifyByMailer($username, Collection $industries)
    {
        $message = (new Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    [
                        'name' => $username,
                    ]
                ),
                'text/html'
            );


    }

}