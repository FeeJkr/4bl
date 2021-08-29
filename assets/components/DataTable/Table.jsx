import React from "react";
import {Link} from "react-router-dom";

export default function Table({headers, rows, actionButtons}) {
    return (
        <table className="table align-middle table-nowrap table-check">
            <thead className="table-light">
            <tr>
                {headers.forEach((header) => <th>{header}</th>)}
            </tr>
            </thead>
            <tbody id="table-companies-body">
            {invoices.map(function (invoice, key) {
                return (
                    <tr key={invoice.id} className={'documents-tr'} style={{position: 'relative'}}>
                        <th scope="row">{++key}</th>
                        <td>{invoice.invoiceNumber}</td>
                        <td>{invoice.generatedAt}</td>
                        <td>{invoice.soldAt}</td>
                        <td>{invoice.sellerName}</td>
                        <td>{invoice.buyerName}</td>
                        <td>{invoice.totalNetPrice} {invoice.currencyCode}</td>
                        <td className="gap-3 action-buttons" style={{gridGap: '1 rem', position: 'absolute', right: 0, width: 40 * 3 + 'px'}}>
                            <a onClick={() => handleDownload(invoice.id, invoice.invoiceNumber)}
                               style={{fontSize: '18 px', cursor: 'pointer'}}>
                                <i className="bi bi-download"
                                   style={{fontSize: '18 px'}}
                                />
                            </a>
                            <Link to={'/invoices/documents/edit/' + invoice.id}>
                                <i className="bi bi-pencil"
                                   style={{color: '#34c38f', fontSize: '18 px'}}
                                />
                            </Link>
                            <a onClick={() => handleDelete(invoice.id)}
                               style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                                <i className="bi bi-trash"
                                   style={{color: '#f46a6a', fontSize: '18 px'}}
                                />
                            </a>
                        </td>
                    </tr>
                );
            })}
            </tbody>
        </table>
    );
}