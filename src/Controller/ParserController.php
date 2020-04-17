<?php


namespace App\Controller;


use App\Service\Competition\RFBRService;
use App\Service\Competition\ServiceFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ParserController
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
            $type    = $request->get('type', RFBRService::ABBREVIATION);
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