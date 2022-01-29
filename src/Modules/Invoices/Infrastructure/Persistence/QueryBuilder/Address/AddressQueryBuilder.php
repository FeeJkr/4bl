<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\Address;

use Doctrine\DBAL\Query\QueryBuilder;

final class AddressQueryBuilder
{
    private const DATABASE_TABLE = 'invoices_addresses';
    private const DATABASE_TABLE_ALIAS = 'ia';

    public static function addJoin(
        QueryBuilder $queryBuilder,
        string $alias,
        string $foreignKey,
        array $select,
        string $parentKey = 'id',
    ): QueryBuilder {
        return $queryBuilder
            ->addSelect(
                ...array_map(
                    static fn (string $row) => sprintf('%s.%s', self::DATABASE_TABLE_ALIAS, $row),
                    $select
                )
            )
            ->join(
                $alias,
                self::DATABASE_TABLE,
                self::DATABASE_TABLE_ALIAS,
                sprintf('%s.%s = %s.%s', self::DATABASE_TABLE_ALIAS, $parentKey, $alias, $foreignKey),
            );
    }
}
