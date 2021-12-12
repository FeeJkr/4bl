<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class DeleteCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext){}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $id = CategoryId::fromString($command->id);
        $category = $this->repository->getById($id, $this->userContext->getUserId());

        $this->repository->delete($category);
    }
}
