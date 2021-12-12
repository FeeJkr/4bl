<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Finances\Application\Category\CategoryDTO;
use App\Modules\Finances\Application\Category\GetById\GetCategoryByIdQuery;
use App\Web\API\Action\AbstractAction;

final class GetCategoryByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetCategoryByIdRequest $request): GetCategoryByIdResponse
    {
        /** @var CategoryDTO $category */
        $category = $this->bus->handle(new GetCategoryByIdQuery($request->id));

        return GetCategoryByIdResponse::respond($category);
    }
}
