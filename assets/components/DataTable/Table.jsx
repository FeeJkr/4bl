import React from "react";

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
                <tr key={row.id} className={'documents-tr'} style={{position: 'relative'}}>
                    <th scope="row">{++key}</th>
                    <td>{row.value}</td>
                    <td>{row.generatedAt}</td>
                    <td>{row.soldAt}</td>
                    <td>{row.sellerName}</td>
                    <td>{row.buyerName}</td>
                    <td>{row.totalNetPrice} {row.currencyCode}</td>
                    <td className="gap-3 action-buttons" style={{gridGap: '1 rem', position: 'absolute', right: 0, width: 40 * 3 + 'px'}}>
                        {actionButtons.map(() => (<ActionButton/>))}
                    </td>
                </tr>
            ))}
            </tbody>
        </table>
    );
}