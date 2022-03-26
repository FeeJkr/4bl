<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Contractor;

use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Address\AddressQueryBuilder;
use Doctrine\DBAL\Query\QueryBuilder;

final class ContractorQueryBuilder
{
    private const DATABASE_TABLE = 'invoices_contractors';
    private const DATABASE_TABLE_ALIAS = 'ic';

    private const COLUMNS = [
        'id',
        'users_id',
        'name',
        'identification_number',
    ];

    private const ADDRESS_FOREIGN_KEY = 'invoices_addresses_id';
    private const ADDRESS_COLUMNS = [
        'id AS address_id',
        'name AS address_name',
        'street AS address_street',
        'city AS address_city',
        'zip_code AS address_zip_code',
    ];

    public static function buildSelect(QueryBuilder $queryBuilder, string $userId): QueryBuilder
    {
        $queryBuilder
            ->select(
                ...array_map(
                static fn (string $column) => sprintf('%s.%s', self::DATABASE_TABLE_ALIAS, $column),
                self::COLUMNS,
            ),
            )
            ->from(self::DATABASE_TABLE, self::DATABASE_TABLE_ALIAS)
            ->where(sprintf('%s.users_id = :userId', self::DATABASE_TABLE_ALIAS))
            ->setParameters([
                'userId' => $userId,
            ]);

        AddressQueryBuilder::addJoin(
            $queryBuilder,
            self::DATABASE_TABLE_ALIAS,
            self::ADDRESS_FOREIGN_KEY,
            self::ADDRESS_COLUMNS,
        );

        return $queryBuilder;
    }

    public static function buildSelectWithId(QueryBuilder $queryBuilder, string $userId, string $id): QueryBuilder
    {
        return self::buildSelect($queryBuilder, $userId)
            ->andWhere(sprintf('%s.id = :id', self::DATABASE_TABLE_ALIAS))
            ->setParameter('id', $id);
    }
}
