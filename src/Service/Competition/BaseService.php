<?php


namespace App\Service\Competition;


use App\Entity\Competition;
use App\Entity\SupportSite;
use App\Exception\CompetitionException;
use App\Exception\SupportSiteException;
use App\Parser\Parser;
use App\Service\DataLoadService;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseService
{
    const ABBREVIATION = '';

    protected Parser                   $parser;
    protected EntityManagerInterface   $entityManager;

    protected ?SupportSite $supportSite = null;

    /**
     * BaseService constructor.
     *
     * @param Parser                 $parser
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Parser $parser,
        EntityManagerInterface $entityManager
    ) {
        $this->parser        = $parser;
        $this->entityManager = $entityManager;
    }

    /**
     * Обязательно вызвать initRun()
     *
     * @return void
     */
    abstract public function run() : void;

    /**
     * @throws SupportSiteException
     */
    public function initRun()
    {
        /** @var SupportSite|null $supportSite */
        $supportSite = $this->entityManager->getRepository(SupportSite::class)->findOneBy([
            'abbreviation' => static::ABBREVIATION,
        ]);

        if ($supportSite === null) {
            throw new SupportSiteException('', 201);
        }

        $this->supportSite = $supportSite;
        $this->parser->setSupportSiteIndustries($supportSite->getSupportSitesIndustries()->toArray());
    }

    /**
     * @param string|null $url
     *
     * @throws CompetitionException
     */
    public function addCompetitionByURL(?string $url) : void
    {
        $data = DataLoadService::loadHTMLFromURL($url);

        $competition = $this->parser->parse($data);
        $competition->setUrl($url);
        $competition->setUpdateDate();

        $old_competition = $this->entityManager
            ->getRepository(Competition::class)
            ->findOneBy(['url' => $url]);
        if ($old_competition instanceof Competition) {
            if ($old_competition->getGrantSize() == $competition->getGrantSize()
                && $old_competition->getDeadline() == $competition->getDeadline()
            ) {
                return;
            }

            $this->entityManager->remove($old_competition);
            $this->entityManager->flush();
        }

        $this->entityManager->persist($competition);
        $this->entityManager->flush();
    }
}