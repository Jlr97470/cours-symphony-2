<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class LogSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private RequestStack $requestStack
    ){
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->logger->info(sprintf("Coucou Request From %s", $request->getClientIp()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            "kernel.request" => 'onKernelRequest',
        ];
    }
}
