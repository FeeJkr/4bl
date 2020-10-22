<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Category\UpdateCategoryRequest;
use App\Web\API\Service\Finances\Category\CategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UpdateCategoryAction extends AbstractAction
{
    private CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $request = UpdateCategoryRequest::createFromServerRequest($request);

        $this->service->updateCategory($request);

        return $this->noContentResponse();
    }
}