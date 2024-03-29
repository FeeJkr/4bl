<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\User;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Invoices\Domain\User\UserContext as UserContextInterface;
use App\Modules\Invoices\Domain\User\UserId;

final class UserContext implements UserContextInterface
{
    public function __construct(private readonly HttpRequestContext $httpRequestContext){}

    public function getUserId(): UserId
    {
        return UserId::fromString($this->httpRequestContext->getUserIdentity());
    }
}
