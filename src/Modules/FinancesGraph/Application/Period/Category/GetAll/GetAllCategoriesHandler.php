<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Application\Period\Category\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\FinancesGraph\Application\Period\Category\CategoriesCollection;
use App\Modules\FinancesGraph\Application\Period\Category\CategoryRepository;

final class GetAllCategoriesHandler implements QueryHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(GetAllCategoriesQuery $query): CategoriesCollection
    {
        return $this->repository->fetchAll($query->periodId);
    }
}
