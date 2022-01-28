<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

use App\Common\Application\Query\QueryHandler;
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
                'ic.id',
                'ia.id as address_id',
                'ia.street as address_street',
                'ia.city as address_city',
                'ia.zip_code as address_zip_code',
                'ic.name',
                'ic.identification_number',
                'ic.is_vat_payer',
                'ic.vat_rejection_reason',
                'ic.email',
                'ic.phone_number',
            )
            ->from('invoices_companies', 'ic')
            ->join('ic', 'invoices_addresses', 'ia', 'ia.id = ic.invoices_addresses_id')
            ->where('ic.users_id = :userId')
            ->setParameters([
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAllAssociative();

        return new CompaniesCollection(
            ...array_map(static fn (array $row) => CompanyDTO::fromStorage($row), $rows)
        );
    }
}
