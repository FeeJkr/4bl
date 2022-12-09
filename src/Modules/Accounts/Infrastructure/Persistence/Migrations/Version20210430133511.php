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
        $this->addSql('CREATE SCHEMA IF NOT EXISTS accounts;');

        $this->addSql(
            "CREATE TYPE accounts.users_status AS ENUM ('active', 'disable', 'email_verification');"
        );

        $this->addSql("
            create table accounts.users(
                id uuid not null unique constraint users_pk primary key,
                email varchar(255) unique not null,
                username varchar(255) unique not null,
                password varchar(255) not null,
                first_name varchar(255) not null,
                last_name varchar(255) not null,
                status accounts.users_status default 'active',
                registered_at timestamp default now() not null,
                updated_at timestamp
            );
        ");

        $this->addSql("
            CREATE INDEX users_email_index ON accounts.users(email)
        ");

        $this->addSql("
            CREATE INDEX users_username_index ON accounts.users(username)    
        ");

        $this->addSql("
            CREATE INDEX users_status_index ON accounts.users(status)
        ");
    }

    public function down(Schema $schema): void
    {
    }
}
