<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210430135526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create invoices module tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA IF NOT EXISTS invoices');

        $this->addSql('
            create table invoices.addresses
            (
                id uuid default gen_random_uuid() not null unique constraint addresses_pk primary key,
                users_id uuid not null,
                name varchar(255) not null,
                street varchar(255) not null,
                zip_code varchar(7) not null,
                city varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices.companies
            (
                id uuid default gen_random_uuid() not null unique constraint companies_pk primary key,
                users_id uuid not null,
                addresses_id uuid not null constraint companies_addresses_id_fk references invoices.addresses on delete set null,
                name varchar(255) not null,
                identification_number varchar(20) not null,
                is_vat_payer boolean not null,
                vat_rejection_reason int,
                email varchar(255),
                phone_number varchar(255),
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            create table invoices.bank_accounts
            (
                id uuid default gen_random_uuid() not null unique constraint companies_bank_accounts_pk primary key,
                users_id uuid not null,
                companies_id uuid not null constraint bank_accounts_companies_id_fk references invoices.companies on delete cascade,
                name varchar(255) not null,
                bank_name varchar(255) not null,
                bank_account_number varchar(255) not null,
                currency_code varchar(4) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            create table invoices.contractors
            (
                id uuid default gen_random_uuid() not null unique constraint contractors_pk primary key,
                users_id uuid not null,
                addresses_id uuid not null constraint contractors_addresses_id_fk references invoices.addresses on delete set null,
                name varchar(255) not null,
                identification_number varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp 
            )    
        ');

        $this->addSql("CREATE TYPE invoices.invoices_status AS ENUM ('draft', 'send', 'paid')");
        $this->addSql("CREATE TYPE invoices.invoices_payment_type AS ENUM ('bank_transfer', 'cash')");

        $this->addSql('
            create table invoices.invoices
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_pk primary key,
                users_id uuid not null,
                companies_id uuid not null constraint invoices_companies_fk references invoices.companies on delete cascade,
                contractors_id uuid not null constraint invoices_contractors_fk references invoices.contractors on delete cascade,
                bank_accounts_id uuid constraint invoices_bank_accounts_fk references invoices.bank_accounts on delete cascade,
                status invoices.invoices_status not null,
                number varchar(255) not null,
                generate_place varchar(255) not null,
                already_taken_price float not null,
                days_for_payment int not null,
                payment_type invoices.invoices_payment_type not null,
                currency_code varchar(255) not null,
                generated_at timestamp not null,
                sold_at timestamp not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices.invoice_products
            (
                id uuid default gen_random_uuid() not null unique constraint invoice_products_pk primary key,
                invoices_id uuid not null constraint invoices_invoice_products_fk references invoices.invoices on delete cascade,
                position int not null,
                name text not null,
                unit varchar(10) not null,
                quantity int not null,
                net_price float not null,
                gross_price float not null,
                tax_percentage int not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
