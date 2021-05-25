<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class SignInUserRequest extends Request
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(ServerRequest $request): self
    {
    	$requestData = $request->toArray();
    	$email = $requestData['email'];
    	$password = $requestData['password'];

        Assert::lazy()
            ->that($email, 'email')->notEmpty()->email('"%s" is not a valid email address')
            ->that($password, 'password')->notEmpty('"password" field is required.')
            ->verifyNow();

        return new self(
            $email,
            $password
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
