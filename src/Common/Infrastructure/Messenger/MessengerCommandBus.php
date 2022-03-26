<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Application\Command\Command;
use App\Common\Application\Command\CommandBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandBus){}

    public function dispatch(Command $command): mixed
    {
        return $this->commandBus
            ->dispatch($command)
            ->last(HandledStamp::class)
            ?->getResult();
    }
}
