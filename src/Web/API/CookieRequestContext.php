<?php

declare(strict_types=1);

namespace App\Web\API;

use App\Common\Infrastructure\Request\HttpRequestContext;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RequestContext;

final class CookieRequestContext implements HttpRequestContext
{
    public function __construct(private RequestStack $request){}

    public function getUserToken(): string
    {
        return $this->request->getCurrentRequest()->cookies->get('__ACCESS_TOKEN', '');
    }
}
