<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

final class InvoiceProductDTO
{
    public function __construct(
        private string $id,
        private int $position,
        private string $name,
        private float $price,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}