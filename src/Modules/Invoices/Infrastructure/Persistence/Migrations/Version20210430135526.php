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
        $this->addSql('
            create table invoices_addresses
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_addresses_pk primary key,
                users_id uuid not null constraint invoices_addresses_accounts_users_id_fk references accounts_users on delete cascade,
                name varchar(255) not null,
                street varchar(255) not null,
                zip_code varchar(7) not null,
                city varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices_companies
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_companies_pk primary key,
                users_id uuid not null constraint invoices_companies_accounts_users_id_fk references accounts_users on delete cascade,
                invoices_addresses_id uuid not null constraint invoices_companies_invoices_addresses_id_fk references invoices_addresses on delete set null,
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
            create table invoices_bank_accounts
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_companies_bank_accounts_pk primary key,
                users_id uuid not null constraint invoices_bank_accounts_accounts_users_id_fk references accounts_users on delete cascade,
                invoices_companies_id uuid not null constraint invoices_bank_accounts_invoices_companies_id_fk references invoices_companies on delete cascade,
                name varchar(255) not null,
                bank_name varchar(255) not null,
                bank_account_number varchar(255) not null,
                currency_code varchar(4) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            )
        ');

        $this->addSql('
            create table invoices_contractors
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_contractors_pk primary key,
                users_id uuid not null constraint invoices_contractors_accounts_users_id_fk references accounts_users on delete cascade,
                invoices_addresses_id uuid not null constraint invoices_contractors_invoices_addresses_id_fk references invoices_addresses on delete set null,
                name varchar(255) not null,
                identification_number varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp 
            )    
        ');

        $this->addSql("CREATE TYPE invoices_invoices_status AS ENUM ('draft', 'send', 'paid')");
        $this->addSql("CREATE TYPE invoices_invoices_payment_type AS ENUM ('bank_transfer', 'cash')");

        $this->addSql('
            create table invoices_invoices
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_invoices_pk primary key,
                users_id uuid not null constraint invoices_invoices_accounts_users_id_fk references accounts_users on delete cascade,
                invoices_companies_id uuid not null constraint invoices_invoices_invoices_companies_fk references invoices_companies on delete cascade,
                invoices_contractors_id uuid not null constraint invoices_invoices_invoices_contractors_fk references invoices_contractors on delete cascade,
                invoices_bank_accounts_id uuid constraint invoices_invoices_invoices_bank_accounts_fk references invoices_bank_accounts on delete cascade,
                status invoices_invoices_status not null,
                invoice_number varchar(255) not null,
                generate_place varchar(255) not null,
                already_taken_price float not null,
                days_for_payment int not null,
                payment_type invoices_invoices_payment_type not null,
                currency_code varchar(255) not null,
                generated_at timestamp not null,
                sold_at timestamp not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices_invoice_products
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_invoice_products_pk primary key,
                invoices_invoices_id uuid not null constraint invoices_invoice_products_invoices_invoices_fk references invoices_invoices on delete cascade,
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
