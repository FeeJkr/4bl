import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {invoicesActions} from "../../../actions/invoices.actions";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import {filesystemService} from "../../../services/filesystem.service";
import Flatpickr from "react-flatpickr";

function List() {
    const invoices = useSelector(state => state.invoices.documents.all.items);
    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);
    const [dateFilter, setDateFilter] = useState([]);

    useEffect(() => {
        dispatch(invoicesActions.getAll([]));
    }, []);

    useEffect(() => {
        dispatch(invoicesActions.getAll(dateFilter));
    }, [dateFilter]);

    const handleDelete = (id) => {
        dispatch(invoicesActions.deleteInvoice(id));
        setShowToast(true);
    }

    const handleDownload = (filename, invoiceNumber) => {
        filesystemService.getFile(filename).then(file => {
            const element = document.createElement("a");
            element.href = URL.createObjectURL(file);
            element.download = invoiceNumber + ".pdf";
            document.body.appendChild(element);
            element.click();
        });
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Invoices</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right', display: 'flex', justifyContent: 'flex-end'}}>
                                    <div className="mr-4">
                                        <Flatpickr
                                            placeholder="Range"
                                            options={{dateFormat: 'd-m-Y', mode: 'range'}}
                                            className="filter-date-range-input"
                                            onClose={date => setDateFilter(date)}
                                        />
                                    </div>

                                    <div>
                                        <Link to={'/invoices/documents/new'} className="button-create-new btn btn-success">
                                            <i className="bi bi-plus"/>
                                            Generate new
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <table className="table align-middle table-nowrap table-check">
                                    <thead className="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Number</th>
                                        <th>Generated Date</th>
                                        <th>Sold Date</th>
                                        <th>Company</th>
                                        <th>Contractor</th>
                                        <th>Total Net Price</th>
                                        <th>Total Gross Price</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-companies-body">
                                    {invoices && invoices.map(function (invoice, key) {
                                        return (
                                            <tr key={invoice.id} className={'documents-tr'} style={{position: 'relative'}}>
                                                <th scope="row">{++key}</th>
                                                <td>{invoice.invoiceNumber}</td>
                                                <td>{invoice.generatedAt}</td>
                                                <td>{invoice.soldAt}</td>
                                                <td>{invoice.companyName}</td>
                                                <td>{invoice.contractorName}</td>
                                                <td>{invoice.totalNetPrice} {invoice.currencyCode}</td>
                                                <td>{invoice.totalGrossPrice} {invoice.currencyCode}</td>
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
                                    <tfoot>
                                        <tr>
                                            <td colSpan={6}/>
                                            <td>{invoices.map((invoice) => invoice.totalNetPrice).reduce((partialSum, a) => partialSum + a, 0)} PLN</td>
                                            <td>{invoices.map((invoice) => invoice.totalGrossPrice).reduce((partialSum, a) => partialSum + a, 0)} PLN</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Toast style={{position: 'absolute', bottom: 80, right: 20, backgroundColor: '#00ca72'}}
                   onClose={() => setShowToast(false)}
                   show={showToast}
                   delay={5000}
                   autohide
            >
                <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                    <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                </Toast.Header>
                <Toast.Body style={{color: '#fff'}}>
                    Invoice was successfully deleted.
                </Toast.Body>
            </Toast>
        </div>
    );
}

export {List};