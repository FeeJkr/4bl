<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Finances\Application\Category\CategoryDTOCollection;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Web\API\Action\AbstractAction;

final class GetAllCategoriesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetAllCategoriesRequest $request): GetAllCategoriesResponse
    {
        /** @var CategoryDTOCollection $categories */
        $categories = $this->bus->handle(new GetAllCategoriesQuery($request->type));

        return GetAllCategoriesResponse::respond($categories);
    }
}
