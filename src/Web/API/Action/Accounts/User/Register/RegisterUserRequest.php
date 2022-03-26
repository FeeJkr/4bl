<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Register;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class RegisterUserRequest extends Request
{
    public function __construct(
        public readonly string $email,
        public readonly string $username,
        public readonly string $password,
        public readonly string $firstName,
        public readonly string $lastName
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
    	$requestData = $request->toArray();

        $email = $requestData['email'];
        $username = $requestData['username'];
        $password = $requestData['password'];
        $firstName = $requestData['firstName'];
        $lastName = $requestData['lastName'];

        Assert::lazy()
            ->that($email, 'email')->notEmpty()->email()
            ->that($username, 'username')->notEmpty()
            ->that($password, 'password')->notEmpty()->minLength(8)->maxLength(255)
            ->that($firstName, 'firstName')->notEmpty()->maxLength(255)
            ->that($lastName, 'lastName')->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self(
            $email,
            $username,
            $password,
            $firstName,
            $lastName
        );
    }
}
