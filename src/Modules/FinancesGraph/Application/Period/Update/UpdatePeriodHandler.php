<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Update;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Application\Period\Category\Update\UpdateCategoryCommand;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodRepository;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpense;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpenseId;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use DateTimeImmutable;

final class UpdatePeriodHandler implements CommandHandler
{
    public function __construct(
        private PeriodRepository $repository,
        private UserContext $userContext,
        private CommandBus $commandBus,
    ){}

    public function __invoke(UpdatePeriodCommand $command): void
    {
        $period = $this->repository->fetchById(
            PeriodId::fromString($command->id),
            $this->userContext->getUserId(),
        );

        $period->update(
            $command->name,
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->endAt),
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->startAt),
            $command->startBalance,
            array_map(
                static fn(array $expense) => new PlannedMandatoryExpense(
                    PlannedMandatoryExpenseId::generate(),
                    PeriodId::fromString($period->snapshot()->id),
                    DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $expense['date']),
                    $expense['amount'],
                ),
                $command->plannedMandatoryExpenses
            ),
        );

        foreach ($command->categories as $category) {
            $this->commandBus->dispatch(
                new UpdateCategoryCommand(
                    $category['id'],
                    $category['name'],
                    (float) $category['balance'],
                    (bool) $category['isMandatory'],
                )
            );
        }

        $this->repository->save($period->snapshot());
    }
}
