<?php


namespace App\Service;


use App\Entity\ApiSubscriber;
use App\Exception\SubscribeException;
use Doctrine\ORM\EntityManagerInterface;

class SubscribeService
{
    const KEY       = 'HALA_MADRID!';
    const ALGORITHM = 'sha256';

    protected EntityManagerInterface   $entityManager;

    /**
     * SubscribeService constructor.
     *
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }

    /**
     * @param string $app_name
     *
     * @return string
     * @throws SubscribeException
     */
    public function subscribeApp(string $app_name)
    {
        $apiSubscriber = $this->entityManager->getRepository(ApiSubscriber::class)->findOneBy(['name' => $app_name]);
        if ($apiSubscriber instanceof ApiSubscriber) {
            throw new SubscribeException("", 310);
        }

        $token         = hash_hmac(self::ALGORITHM, $app_name, self::KEY);
        $apiSubscriber = new ApiSubscriber();
        $apiSubscriber->setName($app_name);
        $apiSubscriber->setToken($token);
        $apiSubscriber->setSubscribeDate(new \DateTime());

        return $token;
    }

    /**
     * @param string $email
     * @param array  $industries
     */
    public function subscribeEmail(string $email, array $industries = [])
    {
    }

    /**
     * @param array $emails
     */
    public function subscribeEmails(array $emails)
    {
        foreach ($emails as $item) {
            $this->subscribeEmail($item['email'], $item['industries'] ?? []);
        }
    }

}