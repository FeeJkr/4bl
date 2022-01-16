<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Contractor;

use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Contractor\Contractor;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\Contractor\ContractorSnapshot;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use JetBrains\PhpStorm\Pure;

final class ContractorDbRepository implements ContractorRepository
{
    private const DATABASE_TABLE = 'invoices_contractors';

    public function __construct(private Connection $connection){}

    public function nextIdentity(): ContractorId
    {
        return ContractorId::generate();
    }

    /**
     * @throws Exception
     */
    public function fetchById(ContractorId $id, UserId $userId): Contractor
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'invoices_addresses_id',
                'name',
                'identification_number',
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
            throw new \RuntimeException(); // TODO: FIX THROW EXCEPTION
        }

        return $this->createEntityFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(ContractorSnapshot $contractor): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'invoices_addresses_id' => ':addressId',
                'name' => ':name',
                'identification_number' => ':identificationNumber',
            ])
            ->setParameters([
                'id' => $contractor->id,
                'userId' => $contractor->userId,
                'addressId' => $contractor->addressId,
                'name' => $contractor->name,
                'identificationNumber' => $contractor->identificationNumber,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(ContractorSnapshot $contractor): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('name', ':name')
            ->set('identification_number', ':identificationNumber')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $contractor->id,
                'userId' => $contractor->userId,
                'name' => $contractor->name,
                'identificationNumber' => $contractor->identificationNumber,
                'updatedAt' => new DateTimeImmutable(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(ContractorId $id, UserId $userId): void
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
    private function createEntityFromRow(array $row): Contractor
    {
        return new Contractor(
            ContractorId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            AddressId::fromString($row['invoices_addresses_id']),
            $row['name'],
            $row['identification_number'],
        );
    }
}
