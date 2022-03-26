<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryRepository;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\User\UserContext;

final class DeleteCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete(
            CategoryId::fromString($command->id)
        );
    }
}
