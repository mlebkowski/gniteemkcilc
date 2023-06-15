<?php

declare(strict_types=1);

namespace App\Application\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class ResponseSerializerSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): iterable
    {
        yield KernelEvents::VIEW => 'onKernelView';
    }

    public function __construct(private NormalizerInterface $normalizer)
    {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $event->setResponse(
            new JsonResponse(
                $this->normalizer->normalize(
                    $event->getControllerResult(),
                ),
            ),
        );
    }
}
