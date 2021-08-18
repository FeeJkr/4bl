<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\CompanyAddress;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

final class CompanyAddressRepository
{
    private const DATABASE_TABLE = 'invoices_company_addresses';
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function store(CompanyAddress $address): void
    {
        $snapshot = $address->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'street' => ':street',
                'zip_code' => ':zipCode',
                'city' => ':city',
            ])
            ->setParameters([
                'id' => $snapshot->getId(),
                'street' => $snapshot->getStreet(),
                'zipCode' => $snapshot->getZipCode(),
                'city' => $snapshot->getCity(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyAddress $address): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('id = :id')
            ->setParameter('id', $address->getSnapshot()->getId())
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function save(CompanyAddress $address): void
    {
        $snapshot = $address->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('street', ':street')
            ->set('zip_code', ':zipCode')
            ->set('city', ':city')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->setParameters([
                'id' => $snapshot->getId(),
                'street' => $snapshot->getStreet(),
                'zipCode' => $snapshot->getZipCode(),
                'city' => $snapshot->getCity(),
                'updatedAt' => (new DateTimeImmutable())->format(self::DATETIME_FORMAT),
            ])
            ->execute();
    }
}