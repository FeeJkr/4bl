<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company;

use App\Modules\Invoices\Domain\Address\AddressRepository;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Company\CompanySnapshot;
use App\Modules\Invoices\Domain\User\UserId;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Company\CompanyQueryBuilder;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CompanyDbRepository implements CompanyRepository
{
    private const DATABASE_TABLE = 'invoices_companies';

    public function __construct(private Connection $connection, private AddressRepository $addressRepository){}

    /**
     * @throws Exception
     */
    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = CompanyQueryBuilder::buildSelectWithId($queryBuilder, $userId->toString(), $id->toString())
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: FIX THIS EXCEPTION
        }

        return CompanyFactory::createFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function fetchByUserId(UserId $userId): Company
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = CompanyQueryBuilder::buildSelect($queryBuilder, $userId->toString())->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: FIX THIS EXCEPTION
        }

        return CompanyFactory::createFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(CompanySnapshot $company): void
    {
        $this->addressRepository->store($company->address);

        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'invoices_addresses_id' => ':addressId',
                'name' => ':name',
                'identification_number' => ':identificationNumber',
                'is_vat_payer' => ':isVatPayer',
                'vat_rejection_reason' => ':vatRejectionReason',
                'email' => ':email',
                'phone_number' => ':phoneNumber'
            ])
            ->setParameters([
                'id' => $company->id,
                'userId' => $company->userId,
                'addressId' => $company->address->id,
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer ? 1 : 0,
                'vatRejectionReason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(CompanySnapshot $company): void
    {
        $this->addressRepository->save($company->address);

        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('name', ':name')
            ->set('identification_number', ':identificationNumber')
            ->set('is_vat_payer', ':isVatPayer')
            ->set('vat_rejection_reason', ':vatRejectionReason')
            ->set('email', ':email')
            ->set('phone_number', ':phoneNumber')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $company->id,
                'userId' => $company->userId,
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer ? 1 : 0,
                'vatRejectionReason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
                'updatedAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyId $id, UserId $userId): void
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
