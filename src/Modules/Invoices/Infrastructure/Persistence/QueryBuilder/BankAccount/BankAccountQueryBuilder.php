<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\BankAccount;

use Doctrine\DBAL\Query\QueryBuilder;

final class BankAccountQueryBuilder
{
    private const DATABASE_TABLE = 'invoices.bank_accounts';
    private const DATABASE_TABLE_ALIAS = 'ba';

    private const COLUMNS = [
        'id',
        'users_id',
        'companies_id',
        'name',
        'bank_name',
        'bank_account_number',
        'currency_code',
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

        return $queryBuilder;
    }

    public static function buildSelectWithId(QueryBuilder $queryBuilder, string $userId, string $id): QueryBuilder
    {
        return self::buildSelect($queryBuilder, $userId)
            ->andWhere(sprintf('%s.id = :id', self::DATABASE_TABLE_ALIAS))
            ->setParameter('id', $id);
    }

    public static function buildSelectWithCompanyId(
        QueryBuilder $queryBuilder,
        string $userId,
        string $companyId
    ): QueryBuilder {
        return self::buildSelect($queryBuilder, $userId)
            ->andWhere(sprintf('%s.companies_id = :companyId', self::DATABASE_TABLE_ALIAS))
            ->setParameter('companyId', $companyId);
    }
}
