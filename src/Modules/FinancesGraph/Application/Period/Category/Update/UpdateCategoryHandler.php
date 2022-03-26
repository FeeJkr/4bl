<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\Update;

use App\Common\Application\Command\CommandHandler;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryId;
use App\Modules\FinancesGraph\Domain\Period\Category\CategoryRepository;

final class UpdateCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $category = $this->repository->fetchById(CategoryId::fromString($command->id));

        $category->update(
            $command->name,
            $command->balance,
            $command->isMandatory,
        );

        $this->repository->save($category->snapshot());
    }
}
