<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211118200046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add confirmation users email table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            create table accounts_users_confirmation(
                user_id uuid not null unique constraint users_confirmation_accounts_users_id_fk references accounts_users on delete cascade,
                email varchar(255) not null unique,
                confirmation_token varchar(255) unique not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ");

        $this->addSql("
            CREATE INDEX accounts_users_confirmation_email_index ON accounts_users_confirmation(email)
        ");

        $this->addSql("
            CREATE INDEX accounts_users_confirmation_confirmation_token_index ON accounts_users_confirmation(confirmation_token)    
        ");

    }

    public function down(Schema $schema): void
    {
    }
}
