<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Register;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class RegisterUserRequest extends Request
{
    public function __construct(
        private string $email,
        private string $username,
        private string $password,
        private string $firstName,
        private string $lastName
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
