<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\GetOneById;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryDTO;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryRepository;

final class GetOneCategoryByIdHandler implements QueryHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(GetOneCategoryByIdQuery $query): CategoryDTO
    {
        return $this->repository->fetchOneById($query->id);
    }
}
