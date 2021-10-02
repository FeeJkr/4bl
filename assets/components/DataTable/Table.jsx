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
            {rows.map((row, key) => (
                <tr key={invoice.id} className={'documents-tr'} style={{position: 'relative'}}>
                    <th scope="row">{++key}</th>
                    <td>{invoice.value}</td>
                    <td>{invoice.generatedAt}</td>
                    <td>{invoice.soldAt}</td>
                    <td>{invoice.sellerName}</td>
                    <td>{invoice.buyerName}</td>
                    <td>{invoice.totalNetPrice} {invoice.currencyCode}</td>
                    <td className="gap-3 action-buttons" style={{gridGap: '1 rem', position: 'absolute', right: 0, width: 40 * 3 + 'px'}}>
                        {actionButtons.map(() => (<ActionButton/>))}
                    </td>
                </tr>
            ))}
            </tbody>
        </table>
    );
}