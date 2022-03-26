<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Application\Period\Update\UpdatePeriodCommand;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemCategory;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemRepository;
use DateTimeImmutable;

final class UpdatePeriodItemHandler implements CommandHandler
{
    public function __construct(private PeriodItemRepository $repository){}

    public function __invoke(UpdatePeriodItemCommand $command): void
    {
        $periodItem = $this->repository->fetchById(PeriodItemId::fromString($command->id));

        $periodItem->update(
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->date),
            array_map(
                static fn(array $item) => new PeriodItemCategory(
                    PeriodItemId::fromString($item['id']),
                    CategoryId::fromString($item['categoryId']),
                    $item['amount'],
                ),
                $command->items
            ),
        );

        $this->repository->save($periodItem->snapshot());
    }
}
