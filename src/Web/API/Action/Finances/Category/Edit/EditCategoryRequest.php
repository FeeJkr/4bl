<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Edit;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class EditCategoryRequest extends Request
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $icon,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();

        $id = $request->get('id');
        $name = $requestData['name'];
        $type = $requestData['type'];
        $icon = $requestData['icon'];

        Assert::lazy()
            ->that($id, 'id')->notEmpty()->uuid()
            ->that($name, 'name')->notEmpty()->maxLength(254)
            ->that($type, 'type')->notEmpty()
            ->that($icon, 'icon')->notEmpty()->maxLength(254)
            ->verifyNow();

        return new self($id, $name, $type, $icon);
    }
}
