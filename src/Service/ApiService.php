<?php


namespace App\Service;


use App\Entity\ApiSubscriber;
use App\Entity\Competition;
use App\Entity\EmailSubscriber;
use App\Entity\Industry;
use App\Exception\SubscribeException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ApiService
{
    const KEY       = 'HALA_MADRID!';
    const ALGORITHM = 'sha256';

    protected EntityManagerInterface   $entityManager;

    private ?object                    $apiSubscriber = null;

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
     * @param string $appName
     *
     * @return string
     * @throws SubscribeException
     */
    public function subscribeApp(string $appName)
    {
        $apiSubscriber = $this->getAppData($appName);
        if ($apiSubscriber instanceof ApiSubscriber) {
            throw new SubscribeException("", 310);
        }

        $token         = hash_hmac(self::ALGORITHM, $appName, self::KEY);
        $apiSubscriber = new ApiSubscriber();
        $apiSubscriber->setName($appName);
        $apiSubscriber->setToken($token);
        $apiSubscriber->setSubscribeDate(new DateTime());

        $this->apiSubscriber = $apiSubscriber;

        return $token;
    }

    /**
     * @param string $appName
     * @param string $token
     *
     * @return bool
     * @throws SubscribeException
     */
    public function checkApp(string $appName, string $token)
    {
        if ($token === $_ENV['SECRET_ADMIN_KEY']) {
            return true;
        }

        $apiSubscriber = $this->getAppData($appName);
        if ($apiSubscriber instanceof ApiSubscriber) {
            if ($apiSubscriber->getToken() !== $token) {
                throw new SubscribeException("", 311);
            }

            return true;
        } else {
            throw new SubscribeException("", 312);
        }
    }

    /**
     * @param string $appName
     *
     * @return ApiSubscriber|object|null
     */
    public function getAppData(string $appName)
    {
        if ($this->apiSubscriber === null) {
            $this->apiSubscriber = $this->entityManager
                ->getRepository(ApiSubscriber::class)->findOneBy(['name' => $appName,]);
        }

        return $this->apiSubscriber;
    }

    /**
     * @param string $appName
     * @param string $email
     * @param array  $industries
     */
    public function subscribeEmail(string $appName, string $email, array $industries = [])
    {
        $emailSubscriber = $this->entityManager
            ->getRepository(EmailSubscriber::class)
            ->findOneBy(['email' => $email,]);

        if (!($emailSubscriber instanceof EmailSubscriber)) {
            $emailSubscriber = new EmailSubscriber();
            $emailSubscriber->setEmail($email);
            $emailSubscriber->setApiSubscriber($this->getAppData($appName));
        }

        foreach ($industries as $industry) {
            $newIndustry = $this->entityManager
                ->getRepository(Industry::class)
                ->find($industry);
            if ($newIndustry instanceof Industry) {
                $emailSubscriber->addIndustry($newIndustry);
            }
        }

        $this->entityManager->persist($emailSubscriber);
        $this->entityManager->flush();
    }

    /**
     * @param string $appName
     * @param array  $emails
     */
    public function subscribeEmails(string $appName, array $emails)
    {
        foreach ($emails as $item) {
            $this->subscribeEmail($appName, $item['email'], $item['industries'] ?? []);
        }
    }


    /**
     * @param string        $appName
     * @param DateTime|null $date
     *
     * @return array
     */
    public function getCompetitions(string $appName, ?DateTime $date = null)
    {
        $competitions = [];

        $apiSubscriber = $this->getAppData($appName);

        $temp = $this->entityManager
            ->getRepository(Competition::class)
            ->getCompetitionsBy($date ?? $apiSubscriber->getLastGetAllDate());
        if ($temp !== null) {
            $competitions = $temp;
            $apiSubscriber->setLastGetAllDate(new DateTime());

            $this->entityManager->persist($apiSubscriber);
            $this->entityManager->flush();

            $this->apiSubscriber = $apiSubscriber;
        }

        return $competitions;
    }

    /**
     * @param string $appName
     *
     * @return array
     */
    public function getNotifyEmails(string $appName)
    {
        $emails = [];

        /** @var EmailSubscriber $emailSubscriber */
        foreach ($this->getAppData($appName)->getEmailSubscribers() as $emailSubscriber) {
            $emails[$emailSubscriber->getEmail()] = [];
            /** @var Industry $industry */
            foreach ($emailSubscriber->getIndustries() as $industry) {
                /** @var Competition $competition */
                foreach ($industry->getCompetitions() as $competition) {
                    if ($emailSubscriber->getLastSubscribeDate() !== null
                        || ($emailSubscriber->getLastSubscribeDate() !== null
                            && $competition->getUpdateDate() < $this->getAppData($appName)->getLastGetAllDate())
                    ) {
                        continue;
                    }
                    $emails[$emailSubscriber->getEmail()][] = [
                        'id'   => $competition->getId(),
                        'name' => $competition->getName(),
                    ];
                }
            }
        }

        return $emails;
    }
}