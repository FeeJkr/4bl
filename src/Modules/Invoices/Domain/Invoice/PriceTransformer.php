<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

interface PriceTransformer
{
    public function transformToText(float $price): string;
}
