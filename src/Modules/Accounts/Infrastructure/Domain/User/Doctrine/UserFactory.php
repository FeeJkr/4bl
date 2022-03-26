<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\ConfirmationToken;
use App\Modules\Accounts\Domain\User\Status;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserId;

final class UserFactory
{
    public static function fromRow(array $row): User
    {
        return new User(
            UserId::fromString($row['id']),
            $row['email'],
            $row['username'],
            $row['password'],
            $row['first_name'],
            $row['last_name'],
            Status::from($row['status']),
            $row['confirmation_token'] ? new ConfirmationToken($row['confirmation_token']) : null,
        );
    }
}
