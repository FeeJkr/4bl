<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\ConfirmEmail;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class ConfirmEmailRequest extends Request
{
    public function __construct(private string $token){}

    public static function fromRequest(ServerRequest $request): self
    {
        return new self(
            $request->get('token')
        );
    }

    public function getToken(): string
    {
        return $this->token;
    }
}