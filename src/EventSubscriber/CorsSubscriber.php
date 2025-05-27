<?php
    namespace App\EventSubscriber;

    use Symfony\Component\EventDispatcher\EventSubscriberInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpKernel\Event\RequestEvent;
    use Symfony\Component\HttpKernel\KernelEvents;

    class CorsSubscriber implements EventSubscriberInterface
    {
        public function onKernelRequest(RequestEvent $event)
        {
            $request = $event->getRequest();

            if ($request->getMethod() !== 'OPTIONS') {
                return;
            }

            // Ici tu peux ajuster les origines, méthodes, headers autorisés
            $response = new JsonResponse(null, 204, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            ]);

            $event->setResponse($response);
        }

        public static function getSubscribedEvents()
        {
            return [
                KernelEvents::REQUEST => ['onKernelRequest', 100],
            ];
        }
    }