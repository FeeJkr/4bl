<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\TokenException;
use App\Modules\Accounts\Domain\User\User;
use DateInterval;
use DateTimeImmutable;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

final class KeycloakIntegration
{
    private static ?string $adminAccessToken = null;

    public function __construct(
        private Client $client,
        private string $keycloakUrl,
        private string $keycloakAdminClient,
        private string $keycloakAdminClientSecret,
        private string $keycloakRealm,
        private string $keycloakClient,
        private string $keycloakSecret,
    ){}

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function addUser(KeycloakUser $user): void
    {
        $url = sprintf('%s/auth/admin/realms/%s/users', rtrim($this->keycloakUrl, '/'), $this->keycloakRealm);

        $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAdminAccessToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'enabled' => true,
                'credentials' => [[
                    'type' => 'password',
                    'value' => $user->getPassword(),
                    'temporary' => false,
                ]],
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function updateUser(string $id, string $firstName, string $lastName): void
    {
        $url = sprintf(
            '%s/auth/admin/realms/%s/users/%s',
            rtrim($this->keycloakUrl, '/'),
            $this->keycloakRealm,
            $id,
        );

        $this->client->put($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAdminAccessToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
            ],
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function getUserByEmail(string $email): array
    {
        $url = sprintf('%s/auth/admin/realms/%s/users', rtrim($this->keycloakUrl, '/'), $this->keycloakRealm);
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAdminAccessToken(),
            ],
            'query' => [
                'email' => $email,
                'max' => 1,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)[0]
            ?? throw new Exception('User with given email not found.');
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function existsByKeyValue(string $key, string $value): bool
    {
        $url = sprintf('%s/auth/admin/realms/%s/users', rtrim($this->keycloakUrl, '/'), $this->keycloakRealm);
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAdminAccessToken(),
            ],
            'query' => [
                $key => $value,
                'max' => 1,
            ],
        ]);

        return !empty(json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function getUserToken(string $email, string $password): Token
    {
        $url = sprintf(
            '%s/auth/realms/%s/protocol/openid-connect/token',
            rtrim($this->keycloakUrl, '/'),
            $this->keycloakRealm
        );

        $response = $this->client->post($url, [
            'form_params' => [
                'username' => $email,
                'password' => $password,
                'client_id' => $this->keycloakClient,
                'client_secret' => $this->keycloakSecret,
                'grant_type' => 'password',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return new Token(
            $data['access_token'],
            $data['refresh_token'],
            (new DateTimeImmutable())->add(new DateInterval(sprintf('PT%dS', $data['refresh_expires_in'])))
        );
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function getUserTokenAfterRefresh(string $refreshToken): Token
    {
        try {
            $url = sprintf(
                '%s/auth/realms/%s/protocol/openid-connect/token',
                rtrim($this->keycloakUrl, '/'),
                $this->keycloakRealm
            );

            $response = $this->client->post($url, [
                'form_params' => [
                    'client_id' => $this->keycloakClient,
                    'client_secret' => $this->keycloakSecret,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return new Token(
                $data['access_token'],
                $data['refresh_token'],
                (new DateTimeImmutable())->add(new DateInterval(sprintf('PT%dS', $data['refresh_expires_in'])))
            );
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() === Response::HTTP_BAD_REQUEST) {
                throw TokenException::invalid();
            }

            throw $exception;
        }
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function getAdminAccessToken(): string
    {
        if (self::$adminAccessToken === null) {
            $url = sprintf('%s/auth/realms/master/protocol/openid-connect/token', rtrim($this->keycloakUrl, '/'));
            $response = $this->client->post($url, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->keycloakAdminClient,
                    'client_secret' => $this->keycloakAdminClientSecret,
                ]
            ]);

            self::$adminAccessToken = json_decode(
                $response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR
            )['access_token'];
        }

        return self::$adminAccessToken;
    }
}