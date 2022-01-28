<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Company\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Company\GetAll\CompanyDTO;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Throwable;

final class GetOneCompanyByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    public function __invoke(GetOneCompanyByIdQuery $query): CompanyDTO
    {
        try {
            $company = $this->connection
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
                ->where('c.id = :id')
                ->andWhere('c.user_id = :userId')
                ->setParameters([
                    'id' => $query->id,
                    'userId' => $this->userContext->getUserId()->toString(),
                ])
                ->fetchAssociative();

            return CompanyDTO::fromStorage($company);
        } catch (Throwable $exception) {
            throw $exception; // TODO: change exception to application.
        }
    }
}
