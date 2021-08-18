<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Application\Event\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus){}

    public function dispatch(object $event): void
    {
        $this->eventBus->dispatch($event);
    }
}