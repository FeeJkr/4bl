<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210430133511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "CREATE TYPE accounts_users_status AS ENUM ('active', 'disable', 'email_verification');"
        );

        $this->addSql("
            create table accounts_users(
                id uuid not null unique constraint accounts_users_pk primary key,
                email varchar(255) unique not null,
                username varchar(255) unique not null,
                password varchar(255) not null,
                first_name varchar(255) not null,
                last_name varchar(255) not null,
                status accounts_users_status default 'active',
                registered_at timestamp default now() not null,
                updated_at timestamp
            );
        ");

        $this->addSql("
            CREATE INDEX accounts_users_email_index ON accounts_users(email)
        ");

        $this->addSql("
            CREATE INDEX accounts_users_username_index ON accounts_users(username)    
        ");

        $this->addSql("
            CREATE INDEX accounts_users_status_index ON accounts_users(status)
        ");
    }

    public function down(Schema $schema): void
    {
    }
}
