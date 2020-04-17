<?php


namespace App\Controller;


use App\Entity\Industry;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class CompetitionController extends AbstractController
{

    /**
     * @Route("/ajax/competition/get", name="get_competitions_by_industry")
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function getCompetitionsByIndustry(
        Request $request,
        EntityManagerInterface $entityManager
    ) : Response {
        $message      = 'OK';
        $competitions = [];

        try {
            $industry_id = $request->get('industry', 1);
            $industry    = $entityManager
                ->getRepository(Industry::class)
                ->findOneBy(['id' => $industry_id]);
            if ($industry instanceof Industry) {
                $competitions = $industry->getCompetitions();
            }
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->json([
            'competitions' => $competitions,
            'message'      => $message,
        ]);
    }

    /**
     * @Route("/ajax/competition/get_all", name="get_all_competitions")
     * @param CompetitionRepository $competitionRepository
     *
     * @return Response
     */
    public function getAllCompetitions(
        CompetitionRepository $competitionRepository
    ) : Response {
        $message      = 'OK';
        $competitions = [];

        try {
            $competitions = $competitionRepository->findAll();
        } catch (Throwable $e) {
            $message = $e->getMessage() ?? 'ERROR';
        }

        return $this->json([
            'competitions' => $competitions,
            'message'      => $message,
        ]);
    }

    /**
     * @Route("/ajax/competition/get_actual", name="get_actual_competitions")
     * @param CompetitionRepository $competitionRepository
     *
     * @return Response
     */
    public function getActualCompetitions(
        CompetitionRepository $competitionRepository
    ) : Response {
        $message      = 'OK';
        $competitions = [];

        try {
            $competitions = $competitionRepository->getActualCompetitions();
        } catch (Throwable $e) {
            $message = $e->getMessage() ?? 'ERROR';
        }

        return $this->json([
            'competitions' => $competitions,
            'message'      => $message,
        ]);
    }
}