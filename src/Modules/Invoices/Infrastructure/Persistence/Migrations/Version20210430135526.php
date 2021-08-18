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
            create table invoices_company_addresses
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_company_addresses_pk primary key,
                street varchar(255) not null,
                zip_code varchar(7) not null,
                city varchar(255) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices_company_payment_information
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_company_payment_information_pk primary key,
                payment_type varchar(255) not null,
                payment_last_day int not null,
                bank varchar(255) not null,
                account_number varchar(40) not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices_companies
            (
                id uuid default gen_random_uuid() not null unique constraint companies_pk primary key,
                user_id uuid not null constraint companies_accounts_users_id_fk references accounts_users on delete cascade,
                company_address_id uuid not null constraint invoices_companies_company_address_id_fk references invoices_company_addresses on delete cascade,
                company_payment_information_id uuid constraint invoices_companies_company_payment_information_id_fk references invoices_company_payment_information on delete cascade,
                name varchar(255) not null,
                identification_number varchar(30) not null,
                email varchar(255),
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');

        $this->addSql('
            create table invoices_invoices
            (
                id uuid default gen_random_uuid() not null unique constraint invoices_invoices_pk primary key,
                user_id uuid not null constraint companies_accounts_users_id_fk references accounts_users on delete cascade,
                seller_company_id uuid not null constraint invoices_seller_companies__fk references invoices_companies on delete cascade,
                buyer_company_id uuid not null constraint invoices_buyer_companies__fk references invoices_companies on delete cascade,
                invoice_number varchar(255) not null,
                generate_place varchar(255) not null,
                already_taken_price float default 0 not null,
                currency_code varchar(255),
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
                invoice_id uuid not null constraint invoices_invoice_products_invoices_id_fk references invoices_invoices on delete cascade,
                position int not null,
                name text not null,
                price float not null,
                created_at timestamp default now() not null,
                updated_at timestamp
            );
        ');
    }

    public function down(Schema $schema): void
    {
    }
}
