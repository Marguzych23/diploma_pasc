<?php


namespace App\Controller;


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
        $status  = false;
        $message = 'Access denied. Token is wrong.';

        try {
            $type  = $request->get('type', 'all');
            $token = $request->get('token');

            if ($token === $_ENV['SECRET_ADMIN_KEY']) {
                if ($type === 'all') {
                    foreach ($serviceFactory::getAll() as $key => $service) {
                        $service->run();
                    }
                } else {
                    $service = $serviceFactory::create($type);
                    $service->run();
                }
                $status  = true;
                $message = 'OK';
            }
        } catch (Throwable $e) {
            $message = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}