<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Event;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Event\EventHandler;
use App\Modules\Accounts\Domain\User\Event\UserWasRegistered;
use App\Modules\Accounts\Infrastructure\Domain\Mail\SendConfirmationEmail\SendRegisterConfirmationEmailCommand;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;

final class SendUserConfirmationEmailAfterRegister implements EventHandler
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(UserWasRegistered $event): void
    {
        $this->bus->dispatch(
            new SendRegisterConfirmationEmailCommand(
                $event->email,
                $event->username,
                $event->firstName,
                $event->lastName,
                $event->confirmationToken,
            )
        );
    }
}
