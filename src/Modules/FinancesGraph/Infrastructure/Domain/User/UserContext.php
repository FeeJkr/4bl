<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Domain\User;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\FinancesGraph\Domain\User\UserContext as UserContextInterface;
use App\Modules\FinancesGraph\Domain\User\UserId;

final class UserContext implements UserContextInterface
{
    public function __construct(private HttpRequestContext $httpRequestContext){}

    public function getUserId(): UserId
    {
        return UserId::fromString($this->httpRequestContext->getUserIdentity());
    }
}
