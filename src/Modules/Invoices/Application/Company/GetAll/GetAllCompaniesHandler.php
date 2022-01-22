<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\CompaniesCollection;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetAllCompaniesHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws Exception
     */
    public function __invoke(GetAllCompaniesQuery $query): CompaniesCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'invoices_addresses_id',
                'name',
                'identification_number',
                'is_vat_payer',
                'vat_rejection_reason',
                'email',
                'phone_number',
            )
            ->from('invoices_companies')
            ->where('c.user_id = :userId')
            ->setParameters([
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        return new CompaniesCollection(
            ...array_map(static fn (array $row) => CompanyDTO::fromStorage($row), $rows)
        );
    }
}
