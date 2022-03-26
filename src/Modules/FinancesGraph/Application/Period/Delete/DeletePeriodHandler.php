<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\Period\PeriodRepository;
use App\Modules\FinancesGraph\Domain\User\UserContext;

final class DeletePeriodHandler implements CommandHandler
{
    public function __construct(private PeriodRepository $repository, private UserContext $userContext){}

    public function __invoke(DeletePeriodCommand $command): void
    {
        $this->repository->delete(
            PeriodId::fromString($command->id),
            $this->userContext->getUserId(),
        );
    }
}
