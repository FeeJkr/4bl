<?php

declare(strict_types=1);

namespace App\Web\API;

use App\Common\Infrastructure\Request\HttpRequestContext;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RequestContext;

final class SessionRequestContext implements HttpRequestContext
{
    public function __construct(private SessionInterface $session){}

    public function getUserIdentity(): string
    {
        return $this->session->get('user.id', '');
    }

    public function setUserIdentity(mixed $identity): void
    {
        $this->session->set('user.id', $identity);
    }
}
