<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\Category\Category;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryRepository;
use App\Modules\FinancesGraph\Domain\Period\PeriodId;
use App\Modules\FinancesGraph\Domain\User\UserContext;

final class CreateCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(CreateCategoryCommand $command): string
    {
        $category = Category::createNew(
            PeriodId::fromString($command->periodId),
            $command->name,
            $command->balance,
            $command->isMandatory,
        );

        $this->repository->store($category->snapshot());

        return $category->snapshot()->id;
    }
}
