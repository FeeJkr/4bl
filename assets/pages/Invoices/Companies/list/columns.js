import React from "react";
import {Link} from "react-router-dom";
import Index from "../BankAccounts";
import {store} from '../../../../reducers/store';
import {selectCompany} from "../store";
export const columns = [
    {
        name: '#',
        sortField: 'id',
        minWidth: '10px',
        cell: (row, index) => <b>{++index}</b>
    },
    {
        name: 'Name',
        sortable: true,
        sortField: 'name',
        minWidth: '200px',
        cell: row => row.name,
    },
    {
        name: 'Identification number',
        sortable: true,
        sortField: 'identificationNumber',
        minWidth: '350px',
        cell: row => row.identificationNumber,
    },
    {
        name: 'Address',
        sortable: false,
        minWidth: '350px',
        cell: row => `${row.address.street}, ${row.address.city}, ${row.address.zipCode}`
    },
    {
        name: 'VAT Status',
        sortable: false,
        minWidth: '100px',
        cell: row => row.isVatPayer ? 'Yes' : <>No (#{row.vatRejectionReason})</>
    },
    {
        name: 'Action',
        minWidth: '110px',
        cell: row => (
            <div className="gap-3"
                 style={{display: 'flex', gridGap: '1 rem'}}>
                <Link to={'/invoices/companies/edit/' + row.id}>
                    <i className="bi bi-pencil edit-contractors-button"
                       style={{color: '#34c38f'}}
                    />
                </Link>
                <a onClick={() => store.dispatch(selectCompany(row))}
                   style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-wallet" style={{color: '#00e5ff'}}/>
                </a>
                <a onClick={() => console.log(row.id)}
                   style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-trash delete-contractors-button"
                       style={{color: '#f46a6a'}}
                    />
                </a>
            </div>
        )
    },
];
