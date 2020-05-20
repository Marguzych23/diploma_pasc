<?php


namespace App\Controller;


use App\Service\SubscribeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriberController extends AbstractController
{

    /**
     * @Route("/ajax/subscribe/app", name="subscribe_app")
     * @param Request          $request
     * @param SubscribeService $subscribeService
     *
     * @return Response
     */
    public function subscribeApp(
        Request $request,
        SubscribeService $subscribeService
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $name  = $request->get('name');
            $token = $subscribeService->subscribeApp($name);
        } catch (\Throwable $e) {
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
     * @Route("/ajax/subscribe/email", name="subscribe_email")
     * @param Request          $request
     * @param SubscribeService $subscribeService
     *
     * @return Response
     */
    public function subscribeEmailOnIndustry(
        Request $request,
        SubscribeService $subscribeService
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
            $email      = $request->get('email');
            $industries = $request->get('industries', []);
            $subscribeService->subscribeEmail($email, $industries);
        } catch (\Throwable $e) {
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
     * @param Request          $request
     * @param SubscribeService $subscribeService
     *
     * @return Response
     */
    public function subscribeEmailsOnIndustry(
        Request $request,
        SubscribeService $subscribeService
    ) : Response {
        $status  = true;
        $message = 'OK';

        try {
//            $emails = $request->get('emails', []);
            $appName = $request->get('app_name', 'default_app');
            $token   = $request->get('token', '');

            if ($subscribeService->checkApp($appName, $token) === true) {
                $emails = $request->get('emails', [
                    [
                        'email'      => 'zasd@mail.ru',
                        'industries' => [1, 3, 5],
                    ],
                    [
                        'email'      => 'zas@mail.ru',
                        'industries' => [1],
                    ],
                ]);
                $subscribeService->subscribeEmails($emails);
            }
        } catch (\Throwable $e) {
            $status  = false;
            $message = $e->getMessage();
        }

        return $this->json([
            'status'  => $status,
            'message' => $message
        ]);
    }
}