<?php

declare(strict_types=1);

namespace App\Web\API;

use App\Common\Infrastructure\Request\HttpRequestContext;
use Symfony\Component\HttpFoundation\RequestStack;

final class SessionRequestContext implements HttpRequestContext
{
    public function __construct(private RequestStack $requestStack){}

    public function getUserIdentity(): string
    {
        return $this->requestStack->getSession()->get('user.id', '') ?? '';
    }

    public function setUserIdentity(mixed $identity): void
    {
        $this->requestStack->getSession()->set('user.id', $identity);
    }
}
