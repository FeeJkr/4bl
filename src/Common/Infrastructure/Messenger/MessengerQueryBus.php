<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Messenger;

use App\Common\Application\Query\Query;
use App\Common\Application\Query\QueryBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class MessengerQueryBus implements QueryBus
{
    public function __construct(private MessageBusInterface $queryBus){}

    public function handle(Query $query): mixed
    {
        return $this->queryBus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ?->getResult();
    }
}
