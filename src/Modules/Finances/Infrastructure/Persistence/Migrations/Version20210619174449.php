<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619174449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create finances module tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA IF NOT EXISTS finances;');

        $this->addSql("CREATE TYPE finances.category_type AS ENUM ('expenses', 'income')");

        $this->addSql("
            create table finances.categories
            (
                id uuid default gen_random_uuid() not null unique constraint categories_pk primary key,
                users_id uuid not null,
                name varchar(255) not null,
                type finances.category_type not null,
                icon varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ");

        $this->addSql("
            create table finances.wallets
            (
                id uuid default gen_random_uuid() not null unique constraint wallets_pk primary key,
                users_id uuid not null,
                name varchar(255) not null,
                start_balance int not null,
                currency varchar(30) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ");
    }

    public function down(Schema $schema): void
    {
    }
}
