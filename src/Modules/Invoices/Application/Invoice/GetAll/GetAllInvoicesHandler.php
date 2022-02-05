<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;

class GetAllInvoicesHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws DBALException
     */
    public function __invoke(GetAllInvoicesQuery $query): InvoicesCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'i.id',
                'i.invoice_number',
                'i.generated_at',
                'i.sold_at',
                'i.currency_code',
                'companies.name as company_name',
                'i.status',
                'contractors.name as contractor_name',
                '(SELECT SUM(net_price) FROM invoices_invoice_products WHERE invoices_invoices_id = i.id) as total_net_price',
                '(SELECT SUM(gross_price) FROM invoices_invoice_products WHERE invoices_invoices_id = i.id) as total_gross_price',
            )
            ->from('invoices_invoices', 'i')
            ->join('i', 'invoices_companies', 'companies', 'companies.id = i.invoices_companies_id')
            ->join('i', 'invoices_contractors', 'contractors', 'contractors.id = i.invoices_contractors_id')
            ->where('i.users_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->executeQuery()
            ->fetchAllAssociative();

        return new InvoicesCollection(
            ...array_map(static fn (array $row) => InvoiceDTO::fromStorage($row), $rows)
        );
    }
}