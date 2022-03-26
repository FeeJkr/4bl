<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Delete;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteCategoryRequest extends Request
{
    public function __construct(public readonly string $id){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $id = $request->get('id');

        Assert::lazy()
            ->that($id, 'id')->notEmpty()->uuid()
            ->verifyNow();

        return new self($id);
    }
}
