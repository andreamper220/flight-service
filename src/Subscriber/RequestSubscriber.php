<?php

namespace App\Subscriber;

use App\Service\MailerService;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    private $mailerService;

    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    /**
     * @param RequestEvent $event
     * @throws TransportExceptionInterface
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $requestData = $event->getRequest()->request->get('data');
        if ($requestData) {
            $this->mailerService->sendEmailsByFlightId(intval($requestData['flight_id']), $requestData['event']);
        };
    }
}
