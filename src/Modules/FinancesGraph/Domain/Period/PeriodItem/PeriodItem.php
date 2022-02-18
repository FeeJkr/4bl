<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Domain\Period\PeriodItem;

use App\Common\Domain\Entity;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use DateTimeImmutable;

final class PeriodItem extends Entity
{
    public function __construct(
        private PeriodItemId $id,
        private PeriodId $periodId,
        private DateTimeImmutable $date,
        private array $items,
    ){}

    public static function createNew(
        PeriodId $periodId,
        DateTimeImmutable $date,
        array $items,
    ): self {
        return new self(
            PeriodItemId::generate(),
            $periodId,
            $date,
            $items,
        );
    }

    public function update(DateTimeImmutable $date, array $items): void
    {
        $this->date = $date;
        $this->items = $items;
    }

    public function snapshot(): PeriodItemSnapshot
    {
        return new PeriodItemSnapshot(
            $this->id->toString(),
            $this->periodId->toString(),
            $this->date,
            array_map(
                static fn (PeriodItemCategory $category) => $category->snapshot(),
                $this->items
            ),
        );
    }
}
