<?php


namespace App\Controller;


use App\Service\Competition\ServiceFactory;
use App\Service\NotificationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ParserController extends AbstractController
{
    /**
     * @Route("/run", name="run_parse")
     * @param Request             $request
     * @param ServiceFactory      $serviceFactory
     *
     * @param NotificationService $notificationService
     *
     * @return Response
     */
    public function parseAction(
        Request $request,
        ServiceFactory $serviceFactory,
        NotificationService $notificationService
    ) : Response {
        $status  = false;
        $message = [];

        try {
            $type         = $request->get('type', 'all');
            $token        = $request->get('token');
            $notifyIsNeed = (bool) $request->get('notify', 0);

            if ($token === $_ENV['SECRET_ADMIN_KEY']) {
                if ($type === 'all') {
                    foreach ($serviceFactory::getAll() as $key => $service) {
                        $service->run();
                        $message[] = $key . ' is parsed';
                    }
                } else {
                    $service = $serviceFactory::create($type);
                    $service->run();
                    $message[] = $type . ' is parsed';
                }

                if ($notifyIsNeed) {
                    $notificationService->notifyUsers();
                    $message[] = 'Users have notified';
                }

                $status = true;
            } else {
                $message = 'Access denied. Token is wrong.';
            }
        } catch (Throwable $e) {
            $message[] = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message,
        ]);
    }
}