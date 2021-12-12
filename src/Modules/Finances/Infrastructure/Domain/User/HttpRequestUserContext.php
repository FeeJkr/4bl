<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\User;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class HttpRequestUserContext implements UserContext
{
    public function __construct(private HttpRequestContext $requestContext){}

    public function getUserId(): UserId
    {
        return UserId::fromString($this->requestContext->getUserIdentity());
    }
}
