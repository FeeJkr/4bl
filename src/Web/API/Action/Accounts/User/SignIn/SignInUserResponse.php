<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Modules\Accounts\Application\User\GetTokenByEmail\TokenDTO;
use App\Web\API\Action\Response;
use DateInterval;
use DateTime;
use Symfony\Component\HttpFoundation\Cookie;

final class SignInUserResponse extends Response
{
    public static function respond(TokenDTO $token): self
    {
        $response = new self([], Response::HTTP_NO_CONTENT);

        $cookie = Cookie::create(
            '__ACCESS_TOKEN',
            $token->getAccessToken(),
            (new DateTime())->add(new DateInterval('P6M'))
        );

        $response->headers->setCookie($cookie);

        return $response;
    }
}