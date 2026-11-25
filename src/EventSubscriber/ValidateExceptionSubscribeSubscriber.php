<?php

namespace App\EventSubscriber;

use App\Exception\ValidateException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidateExceptionSubscribeSubscriber implements EventSubscriberInterface
{
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        if ($e instanceof ValidateException) {
            $event->setResponse(new JsonResponse([
                'errors' => $e->getErrors()
            ]));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onExceptionEvent',
        ];
    }
}
