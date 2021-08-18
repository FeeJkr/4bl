<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\TokenException;
use App\Modules\Accounts\Domain\User\TokenManager;
use App\Modules\Accounts\Domain\User\UserService;
use DateTimeImmutable;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Throwable;

final class KeycloakTokenManager implements TokenManager
{
    public function __construct(private KeycloakIntegration $keycloakIntegration){}

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function generate(string $email, string $password): Token
    {
        return $this->keycloakIntegration->getUserToken($email, $password);
    }

    public function validate(string $accessToken): void
    {
        try {
            $tokenData = json_decode(
                base64_decode(explode('.', $accessToken)[1]),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $now = new DateTimeImmutable();
            $expireAt = (new DateTimeImmutable())->setTimestamp($tokenData['exp']);

            if ($now->diff($expireAt)->invert) {
                throw TokenException::mustBeRefreshed();
            }
        } catch (JsonException) {
            throw TokenException::invalid();
        }
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function refresh(string $refreshToken): Token
    {
        return $this->keycloakIntegration->getUserTokenAfterRefresh($refreshToken);
    }
}