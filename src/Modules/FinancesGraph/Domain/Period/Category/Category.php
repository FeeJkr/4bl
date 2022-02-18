<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\Category;

use App\Common\Domain\Entity;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;

final class Category extends Entity
{
    public function __construct(
        private CategoryId $id,
        private PeriodId $periodId,
        private string $name,
        private float $balance,
        private bool $isMandatory,
    ){}

    public static function createNew(
        PeriodId $periodId,
        string $name,
        float $balance,
        bool $isMandatory,
    ): self {
        if ($isMandatory && $balance === 0.0) {
            throw new \DomainException('ERROR IN DATA'); // TODO: change this exception
        }

        return new self(
            CategoryId::generate(),
            $periodId,
            $name,
            $balance,
            $isMandatory,
        );
    }

    public function update(string $name, float $balance, bool $isMandatory): void
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->isMandatory = $isMandatory;
    }

    public function snapshot(): CategorySnapshot
    {
        return new CategorySnapshot(
            $this->id->toString(),
            $this->periodId->toString(),
            $this->name,
            $this->balance,
            $this->isMandatory,
        );
    }
}
