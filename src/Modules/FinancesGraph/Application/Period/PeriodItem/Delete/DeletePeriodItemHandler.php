<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\PeriodItem\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemId;
use App\Modules\FinancesGraph\Domain\Period\PeriodItem\PeriodItemRepository;

final class DeletePeriodItemHandler implements CommandHandler
{
    public function __construct(private PeriodItemRepository $repository){}

    public function __invoke(DeletePeriodItemCommand $command): void
    {
        $this->repository->delete(
            PeriodItemId::fromString($command->id)
        );
    }
}
