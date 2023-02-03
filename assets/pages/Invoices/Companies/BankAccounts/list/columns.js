import React from "react";
import {store} from "../../../../../reducers/store";
import {deleteBankAccount, selectBankAccount} from "../../store";

export const columns = [
    {
        name: '#',
        sortField: 'id',
        minWidth: '10px',
        maxWidth: '20px',
        cell: (row, index) => <b>{++index}</b>,
    },
    {
        name: 'Name',
        sortable: false,
        minWidth: '100px',
        cell: row => row.name,
    },
    {
        name: 'Bank name',
        sortable: false,
        minWidth: '200px',
        cell: row => row.bankName,
    },
    {
        name: 'Bank account number',
        sortable: false,
        minWidth: '400px',
        cell: row => row.bankAccountNumber,
    },
    {
        name: 'Currency',
        sortable: false,
        minWidth: '100px',
        maxWidth: '100px',
        cell: row => row.currency,
    },
    {
        name: 'Actions',
        sortable: false,
        minWidth: '60px',
        maxWidth: '100px',
        cell: row => (
            <div className="gap-3" style={{display: 'flex', gridGap: '1 rem'}}>
                <a onClick={() => store.dispatch(selectBankAccount(row))} style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-pencil" style={{color: '#34c38f'}}/>
                </a>
                <a onClick={() => store.dispatch(deleteBankAccount(row))} style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-trash" style={{color: '#f46a6a'}}/>
                </a>
            </div>
        )
    }
];