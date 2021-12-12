<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

final class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private CompanyId $sellerId,
        private CompanyId $buyerId,
        private InvoiceParameters $parameters,
        private InvoiceProductsCollection $products,
    ){}

    public static function create(
        UserId $userId,
        CompanyId $sellerId,
        CompanyId $buyerId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): self {
        return new self(
            InvoiceId::generate(),
            $userId,
            $sellerId,
            $buyerId,
            $parameters,
            $products,
        );
    }

    public function update(
        CompanyId $sellerId,
        CompanyId $buyerId,
        InvoiceParameters $parameters,
        InvoiceProductsCollection $products,
    ): void {
        $this->sellerId = $sellerId;
        $this->buyerId = $buyerId;
        $this->parameters = $parameters;
        $this->products = $products;
    }

    public function getSnapshot(): InvoiceSnapshot
    {
        return new InvoiceSnapshot(
            $this->id->toString(),
            $this->userId->toString(),
            $this->sellerId->toString(),
            $this->buyerId->toString(),
            $this->parameters->getSnapshot(),
            array_map(
                static fn(InvoiceProduct $product) => $product->getSnapshot(),
                $this->products->toArray(),
            )
        );
    }
}