<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Create;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Application\Period\Category\Create\CreateCategoryCommand;
use App\Modules\FinancesGraph\Domain\Period\Period;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodRepository;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpense;
use App\Modules\FinancesGraph\Domain\Period\PlannedMandatoryExpenseId;
use App\Modules\FinancesGraph\Domain\User\UserContext;
use DateTimeImmutable;

final class CreatePeriodHandler implements CommandHandler
{
    public function __construct(
        private PeriodRepository $periodRepository,
        private CommandBus $commandBus,
        private UserContext $userContext,
    ){}

    public function __invoke(CreatePeriodCommand $command): string
    {
        $periodId = PeriodId::generate();

        $plannedMandatoryExpenses = array_map(
            static fn (array $expense) => new PlannedMandatoryExpense(
                PlannedMandatoryExpenseId::generate(),
                $periodId,
                DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $expense['date']),
                $expense['amount'],
            ),
            $command->plannedMandatoryExpenses
        );

        $period = new Period(
            $periodId,
            $this->userContext->getUserId(),
            $command->name,
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->startAt),
            DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $command->endAt),
            $command->startBalance,
            $plannedMandatoryExpenses,
        );

        $this->periodRepository->store($period->snapshot());

        foreach ($command->categories as $category) {
            $this->commandBus->dispatch(
                new CreateCategoryCommand(
                    $periodId->toString(),
                    $category['name'],
                    $category['balance'],
                    $category['isMandatory'],
                )
            );
        }

        return $periodId->toString();
    }
}
