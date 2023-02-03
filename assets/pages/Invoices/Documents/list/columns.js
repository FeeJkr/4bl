import {Link} from "react-router-dom";
import React from "react";
import {store} from "../../../../reducers/store";
import {deleteDocument} from "../store";

export const columns = [
    {
        name: '#',
        minWidth: '107px',
        cell: (row, index) => ++index,
    },
    {
        name: 'Number',
        minWidth: '102px',
        cell: row => row.invoiceNumber,
    },
    {
        name: 'Generated Date',
        minWidth: '150px',
        cell: row => row.generatedAt,
    },
    {
        name: 'Sold Date',
        minWidth: '150px',
        cell: row => row.soldAt,
    },
    {
        name: 'Company',
        minWidth: '150px',
        cell: row => row.companyName,
    },
    {
        name: 'Contractor',
        minWidth: '150px',
        cell: row => row.contractorName,
    },
    {
        name: 'Total Net Price',
        minWidth: '150px',
        cell: row => `${row.totalNetPrice.toFixed(2)} ${row.currencyCode}`,
    },
    {
        name: 'Total Gross Price',
        minWidth: '150px',
        cell: row => `${row.totalGrossPrice.toFixed(2)} ${row.currencyCode}`,
    },
    {
        name: 'Actions',
        minWidth: '100px',
        cell: row => (
            <>
                <a onClick={() => console.log('download')}
                   style={{fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-download"
                       style={{fontSize: '18 px'}}
                    />
                </a>
                <Link to={'/invoices/documents/edit/' + row.id}>
                    <i className="bi bi-pencil"
                       style={{color: '#34c38f', fontSize: '18 px'}}
                    />
                </Link>
                <a onClick={() => store.dispatch(deleteDocument(row.id))}
                   style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-trash"
                       style={{color: '#f46a6a', fontSize: '18 px'}}
                    />
                </a>
            </>
        )
    },
];