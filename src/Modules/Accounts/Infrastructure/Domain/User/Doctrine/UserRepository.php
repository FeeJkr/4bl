<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Status;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use App\Modules\Accounts\Infrastructure\Domain\User\KeycloakIntegration;
use App\Modules\Accounts\Infrastructure\Domain\User\KeycloakUser;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Throwable;

final class UserRepository implements UserRepositoryInterface
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private Connection $connection){}

    /**
     * @throws Throwable
     */
    public function store(User $user, string $password): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $user->getSnapshot();

            $this->connection
                ->createQueryBuilder()
                ->insert('accounts_users')
                ->values([
                    'id' => ':id',
                    'email' => ':email',
                    'username' => ':username',
                    'password' => ':password',
                    'first_name' => ':firstName',
                    'last_name' => ':lastName',
                    'status' => ':status'
                ])
                ->setParameters([
                    'id' => $snapshot->getId(),
                    'email' => $snapshot->getEmail(),
                    'username' => $snapshot->getUsername(),
                    'password' => $snapshot->getPassword(),
                    'firstName' => $snapshot->getFirstName(),
                    'lastName' => $snapshot->getLastName(),
                    'status' => $snapshot->getStatus(),
                ])
                ->execute();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    public function fetchByEmail(string $email): ?User
    {
        $row = $this
            ->connection
            ->createQueryBuilder()
            ->select([
                'id',
                'email',
                'username',
                'password',
                'first_name',
                'last_name',
                'status'
            ])
            ->from('accounts_users')
            ->where('email = :email')
            ->andWhere('status = :status')
            ->setParameters([
                'email' => $email,
                'status' => Status::ACTIVE()->getValue(),
            ])
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new User(
            UserId::fromString($row['id']),
            $row['email'],
            $row['username'],
            $row['password'],
            $row['first_name'],
            $row['last_name'],
            new Status($row['status']),
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function fetchByAccessToken(string $accessToken): ?User
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'email', 'username', 'access_token', 'refresh_token', 'refresh_token_expired_at'])
            ->from('accounts_users')
            ->where('access_token = :accessToken')
            ->setParameter('accessToken', $accessToken)
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new User(
            UserId::fromString($row['id']),
            $row['email'],
            $row['username'],
            $userData['firstName'],
            $userData['lastName'],
            new Token(
                $row['access_token'],
                $row['refresh_token'],
                DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $row['refresh_token_expired_at']),
            )
        );
    }

    /**
     * @throws Exception
     */
    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $databaseRows = $this->connection
            ->createQueryBuilder()
            ->select(1)
            ->from('accounts_users')
            ->where('email = :email')
            ->orWhere('username = :username')
            ->setParameters([
                'email' => $email,
                'username' => $username,
            ])
            ->execute()
            ->rowCount();

        return $databaseRows > 0;
    }

    /**
     * @throws Throwable
     */
    public function save(User $user): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $user->getSnapshot();

            $this->connection
                ->createQueryBuilder()
                ->update('accounts_users')
                ->set('access_token', ':accessToken')
                ->set('refresh_token', ':refreshToken')
                ->set('refresh_token_expired_at', ':refreshTokenExpiredAt')
                ->set('updated_at', ':updatedAt')
                ->setParameters([
                    'accessToken' => $snapshot->getAccessToken(),
                    'refreshToken' => $snapshot->getRefreshToken(),
                    'refreshTokenExpiredAt' => $snapshot->getRefreshTokenExpiresAt()?->format(self::DATETIME_FORMAT),
                    'updatedAt' => (new DateTime())->format(self::DATETIME_FORMAT),
                ])
                ->execute();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
