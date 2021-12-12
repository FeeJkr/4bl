<?php

declare(strict_types=1);

namespace App\Common\Application\Command;

use Symfony\Component\Messenger\Envelope;

interface CommandBus
{
    public function dispatch(Command $command): Envelope;
}
