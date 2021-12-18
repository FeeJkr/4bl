<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\Company\Assign;

use App\Common\Application\Command\CommandHandler;

final class AssignCompanyToAccountHandler implements CommandHandler
{
    public function __construct(){}

    public function __invoke(AssignCompanyToAccountCommand $command): void
    {
    }
}
