<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Address;

use App\Modules\Invoices\Domain\Address\Address;
use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\Address\AddressSnapshot;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use JetBrains\PhpStorm\Pure;

final class AddressDbRepository implements AddressRepository
{
    private const DATABASE_TABLE = 'invoices_addresses';

    public function __construct(private Connection $connection){}

    public function nextIdentity(): AddressId
    {
        return AddressId::generate();
    }

    /**
     * @throws Exception
     */
    public function fetchById(AddressId $id, UserId $userId): Address
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'name',
                'street',
                'zip_code',
                'city',
            )
            ->from(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException('TO CHANGE'); // TODO: domain event
        }

        return $this->createEntityFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(AddressSnapshot $address): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'name' => ':name',
                'street' => ':street',
                'zip_code' => ':zipCode',
                'city' => ':city',
            ])
            ->setParameters([
                'id' => $address->id,
                'userId' => $address->userId,
                'name' => $address->name,
                'street' => $address->street,
                'zipCode' => $address->zipCode,
                'city' => $address->city,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(AddressSnapshot $address): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('name', ':name')
            ->set('street', ':street')
            ->set('zip_code', ':zipCode')
            ->set('city', ':city')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $address->id,
                'userId' => $address->userId,
                'name' => $address->name,
                'street' => $address->street,
                'zipCode' => $address->zipCode,
                'city' => $address->city,
                'updatedAt' => new DateTimeImmutable(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(AddressId $id, UserId $userId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeStatement();
    }

    #[Pure]
    private function createEntityFromRow(array $row): Address
    {
        return new Address(
            AddressId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            $row['name'],
            $row['street'],
            $row['zip_code'],
            $row['city'],
        );
    }
}
