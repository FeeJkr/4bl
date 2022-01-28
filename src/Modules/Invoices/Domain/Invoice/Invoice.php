<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Common\Domain\Entity;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\User\UserId;

final class Invoice extends Entity
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private CompanyId $companyId,
        private ContractorId $contractorId,
        private Status $status,
        private InvoiceParameters $parameters,
        private InvoiceProductsCollection $products,
    ){}

    public static function create(
        UserId $userId,
        CompanyId $companyId,
        ContractorId $contractorId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): self {
        $invoice = new self(
            InvoiceId::generate(),
            $userId,
            $companyId,
            $contractorId,
            Status::DRAFT,
            $parameters,
            $products,
        );

//        $invoice->publishDomainEvent(); TODO

        return $invoice;
    }

    public function update(
        CompanyId $companyId,
        ContractorId $contractorId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): void {
        $this->contractorId = $contractorId;
        $this->parameters = $parameters;
        $this->products = $products;
    }

    public function snapshot(): InvoiceSnapshot
    {
        return new InvoiceSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->companyId->toString(),
            $this->contractorId->toString(),
            $this->status->value,
            $this->parameters->getSnapshot(),
            array_map(
                static fn(InvoiceProduct $product) => $product->getSnapshot(),
                $this->products->toArray(),
            )
        );
    }
}
