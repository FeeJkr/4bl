<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\GetMyUserData;

use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Web\API\Action\Response;

final class GetMyUserDataResponse extends Response
{
    public static function respond(UserDTO $userDTO): self
    {
        return new self([
            'id' => $userDTO->getId(),
            'email' => $userDTO->getEmail(),
            'username' => $userDTO->getUsername(),
            'firstName' => $userDTO->getFirstName(),
            'lastName' => $userDTO->getLastName(),
        ]);
    }
}
