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
        $this->addSql('
            create table accounts_users(
                id uuid not null unique constraint accounts_users_pk primary key,
                email varchar(255) unique not null,
                username varchar(255) unique not null,
                access_token text,
                refresh_token text,
                refresh_token_expired_at timestamp,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
