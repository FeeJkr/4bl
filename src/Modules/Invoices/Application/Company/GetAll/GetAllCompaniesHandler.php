<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\CompaniesCollection;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Throwable;

final class GetAllCompaniesHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext) {}

    public function __invoke(GetAllCompaniesQuery $query): CompaniesCollection
    {
        try {
            $companies = new CompaniesCollection();
            $rows = $this->connection
                ->createQueryBuilder()
                ->select(
                    'c.id',
                    'c.name',
                    'ca.street',
                    'ca.zip_code',
                    'ca.city',
                    'c.identification_number',
                    'c.email',
                    'c.phone_number',
                    'cpi.payment_type',
                    'cpi.payment_last_day',
                    'cpi.bank',
                    'cpi.account_number',
                )
                ->from('invoices_companies', 'c')
                ->leftJoin('c', 'invoices_company_addresses', 'ca', 'ca.id = c.company_address_id')
                ->leftJoin('c', 'invoices_company_payment_information', 'cpi', 'cpi.id = c.company_payment_information_id')
                ->where('user_id = :userId')
                ->setParameter('userId', $this->userContext->getUserId()->toString())
                ->executeQuery()
                ->fetchAllAssociative();

            foreach ($rows as $row) {
                $companies->add(CompanyDTO::fromArray($row));
            }

            return $companies;
        } catch (Throwable $exception) {
            throw $exception; // TODO: change exception to application.
        }
    }
}
