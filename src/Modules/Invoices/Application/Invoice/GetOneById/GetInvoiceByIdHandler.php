<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Application\Invoice\InvoiceDTO;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;

class GetInvoiceByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    public function __invoke(GetInvoiceByIdQuery $query): InvoiceDTO
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select([
                'i.id as invoice_id',
                'i.user_id',
                'i.invoice_number',
                'i.already_taken_price',
                'i.generate_place',
                'i.currency_code',
                'i.generated_at',
                'i.sold_at',
                'sc.id as seller_id',
                'sc.name as seller_name',
                'bc.id as buyer_id',
                'bc.name as buyer_name',
                'ip.position as product_position',
                'ip.name as product_name',
                'ip.price as product_price',
            ])
            ->from('invoices', 'i')
            ->join('i', 'invoice_products', 'ip', 'ip.invoice_id = i.id')
            ->join('i', 'companies', 'sc', 'sc.id = i.seller_company_id')
            ->join('i', 'companies', 'bc', 'bc.id = i.buyer_company_id')
            ->where('i.user_id = :userId')
            ->andWhere('i.id = :id')
            ->setParameter('id', $query->getInvoiceId())
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->execute()
            ->fetchAllAssociative();

        return InvoiceDTO::fromRows($rows);
    }
}