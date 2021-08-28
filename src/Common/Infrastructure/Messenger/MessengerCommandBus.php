<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Application\Command\Command;
use App\Common\Application\Command\CommandBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandBus){}

    public function dispatch(Command $command): Envelope
    {
        return $this->commandBus->dispatch($command);
    }
}
