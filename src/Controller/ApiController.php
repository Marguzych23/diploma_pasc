<?php


namespace App\Controller;


use App\Service\ApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ApiController extends AbstractController
{

    /**
     * @Route("/api/subscribe/app", name="api_subscribe_app")
     * @param Request    $request
     * @param apiService $apiService
     *
     * @return Response
     */
    public function subscribeApp(
        Request $request,
        apiService $apiService
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $name  = $request->get('name');
            $token = $apiService->subscribeApp($name);
        } catch (Throwable $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message,
            'token'   => $token ?? null,
        ]);
    }

    /**
     * @Route("/api/subscribe/emails", name="api_subscribe_emails")
     * @param Request    $request
     * @param ApiService $apiService
     *
     * @return Response
     */
    public function subscribeEmailsOnIndustry(
        Request $request,
        ApiService $apiService
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $appName = $request->get('app_name', 'Admin app');
            $token   = $request->get('token', '');

            if ($apiService->checkApp($appName, $token) === true) {
                $emails = $request->get('emails', []);
                $apiService->subscribeEmails($appName, $emails);
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
     * @Route("/api/get", name="api_competitions_get")
     * @param Request    $request
     * @param ApiService $apiService
     *
     * @return Response
     */
    public function getCompetitionsAndNotifications(
        Request $request,
        ApiService $apiService
    ) : Response {
        $status = true;
        $result = [];

        try {
            $appName = $request->get('app_name', 'Admin app');
            $token   = $request->get('token', '');

            if ($apiService->checkApp($appName, $token) === true) {
                $competitions = $request->get('competitions');
                $emails       = $request->get('emails');

                if ($competitions !== null) {
                    $result['$competitions'] = $apiService->getActualCompetitions($appName);
                }
                if ($emails !== null) {
                    $result['emails'] = $apiService->getNotifyEmails($appName);
                }
            }
        } catch (Throwable $e) {
            $status   = false;
            $result[] = $e->getMessage();
        }

        return $this->json([
            'status' => $status,
            'result' => $result,
        ]);
    }
}