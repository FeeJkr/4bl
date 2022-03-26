<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItem;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemCategory;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemRepository;
use DateTimeImmutable;

final class CreatePeriodItemHandler implements CommandHandler
{
    public function __construct(private PeriodItemRepository $repository){}

    public function __invoke(CreatePeriodItemCommand $command): string
    {
        $periodItem = PeriodItem::createNew(
            PeriodId::fromString($command->periodId),
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->date),
            array_map(
                static fn (array $item) => new PeriodItemCategory(
                    PeriodItemId::generate(),
                    CategoryId::fromString($item['categoryId']),
                    $item['amount']
                ),
                $command->items
            ),
        );

        $this->repository->store($periodItem->snapshot());

        return $periodItem->snapshot()->id;
    }
}
