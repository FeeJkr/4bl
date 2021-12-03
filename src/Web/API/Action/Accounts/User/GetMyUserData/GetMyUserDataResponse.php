<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\GetMyUserData;

use App\Modules\Accounts\Application\User\UserDTO;
use App\Web\API\Action\Response;

final class GetMyUserDataResponse extends Response
{
    public static function respond(UserDTO $userDTO): self
    {
        return new self([
            'id' => $userDTO->id,
            'email' => $userDTO->email,
            'username' => $userDTO->username,
            'firstName' => $userDTO->firstName,
            'lastName' => $userDTO->lastName,
        ]);
    }
}
