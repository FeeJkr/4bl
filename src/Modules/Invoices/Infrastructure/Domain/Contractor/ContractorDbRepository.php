<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Contractor;

use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\Contractor\Contractor;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Contractor\ContractorRepository;
use App\Modules\Invoices\Domain\Contractor\ContractorSnapshot;
use App\Modules\Invoices\Domain\User\UserId;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Contractor\ContractorQueryBuilder;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class ContractorDbRepository implements ContractorRepository
{
    private const DATABASE_TABLE = 'invoices_contractors';
    private const DATABASE_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private Connection $connection, private AddressRepository $addressRepository){}

    public function nextIdentity(): ContractorId
    {
        return ContractorId::generate();
    }

    /**
     * @throws Exception
     */
    public function fetchById(ContractorId $id, UserId $userId): Contractor
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = ContractorQueryBuilder::buildSelectWithId($queryBuilder, $userId->toString(), $id->toString())
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: FIX THROW EXCEPTION
        }

        return ContractorFactory::createFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(ContractorSnapshot $contractor): void
    {
        $this->addressRepository->store($contractor->address);

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
                'addressId' => $contractor->address->id,
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
        $this->addressRepository->save($contractor->address);

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
                'updatedAt' => (new DateTimeImmutable())->format(self::DATABASE_DATETIME_FORMAT),
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
}
