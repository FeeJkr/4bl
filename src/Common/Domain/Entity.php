<?php

declare(strict_types=1);

namespace App\Common\Domain;

abstract class Entity
{
    final protected function publishDomainEvent(DomainEvent $domainEvent): void
    {
        DomainEvents::publishEvent($domainEvent);
    }
}
