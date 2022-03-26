<?php

declare(strict_types=1);

namespace App\Modules\FinancesGraph\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220205113742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for FinancesGraph module';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE finances_graphs_periods
            (
                id uuid default gen_random_uuid() not null constraint finances_graphs_periods_pk primary key,
                users_id uuid not null constraint finances_graphs_periods_accounts_users_id_fk references accounts_users on delete cascade,
                name varchar(255) not null,
                start_at timestamp not null,
                end_at timestamp not null,
                start_balance float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            CREATE TABLE finances_graphs_planned_mandatory_expenses
            (
                id uuid default gen_random_uuid() not null constraint finances_graphs_planned_mandatory_expenses_pk primary key,
                finances_graphs_periods_id uuid not null constraint fgpme_fgp_id_fk references finances_graphs_periods on delete cascade,
                date timestamp not null,
                amount float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            CREATE TABLE finances_graphs_period_categories
            (
                id uuid default gen_random_uuid() not null constraint finances_graphs_period_categories_pk primary key,
                finances_graphs_periods_id uuid not null constraint finances_graphs_period_categories_finances_graphs_periods_id_fk references finances_graphs_periods on delete cascade,
                name varchar(255) not null,
                balance float not null,
                is_mandatory bool default false not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            CREATE TABLE finances_graphs_period_items
            (
                id uuid default gen_random_uuid() not null constraint finances_graphs_period_items_pk primary key,
                finances_graphs_periods_id uuid not null constraint finances_graphs_period_items_finances_graphs_periods_id_fk references finances_graphs_periods on delete cascade,
                date timestamp not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            CREATE TABLE finances_graphs_periods_item_categories
            (
                id uuid default gen_random_uuid() not null constraint finances_graphs_periods_item_categories_pk primary key,
                finances_graphs_period_items_id uuid not null constraint fgpic_fgpi_id_fk references finances_graphs_period_items on delete cascade,
                finances_graphs_period_categories_id uuid not null constraint fgpic_fgpc_id_fk references finances_graphs_period_categories on delete cascade,
                amount float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            CREATE UNIQUE INDEX finances_graphs_periods_id_uindex ON finances_graphs_periods (id);
        ');
        $this->addSql('
            CREATE UNIQUE INDEX finances_graphs_planned_mandatory_expenses_id_uindex ON finances_graphs_planned_mandatory_expenses (id);
        ');
        $this->addSql('
            CREATE UNIQUE INDEX finances_graphs_period_categories_id_uindex ON finances_graphs_period_categories (id);
        ');
        $this->addSql('
            CREATE UNIQUE INDEX finances_graphs_period_items_id_uindex ON finances_graphs_period_items (id);
        ');
        $this->addSql('
            CREATE UNIQUE INDEX finances_graphs_periods_item_categories_id_uindex ON finances_graphs_periods_item_categories (id);
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
