<?php


namespace App\Controller;


use App\Service\Competition\RSFService;
use App\Service\Competition\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ParserController extends AbstractController
{
    /**
     * @Route("/run", name="run_parse")
     * @param Request        $request
     * @param ServiceFactory $serviceFactory
     *
     * @return Response
     */
    public function parseAction(
        Request $request,
        ServiceFactory $serviceFactory
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $type = $request->get('type', 'all');

            if ($type === 'all') {
                foreach ($serviceFactory::getAll() as $key => $service) {
                    $service->run();
                }
            } else {
                $service = $serviceFactory::create($type);
                $service->run();
            }
        } catch (Throwable $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/test", name="run_test")
     * @param Request        $request
     * @param ServiceFactory $serviceFactory
     *
     * @return Response
     */
    public function parseTestAction(
        Request $request,
        ServiceFactory $serviceFactory
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $type    = $request->get('type', RSFService::ABBREVIATION);
            $service = $serviceFactory::create($type);
            $service->run();
        } catch (Throwable $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }

}