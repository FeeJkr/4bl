import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import {filesystemService} from "../../../../services/filesystem.service";
import Flatpickr from "react-flatpickr";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect";
import "flatpickr/dist/plugins/monthSelect/style.css";
import {getData} from "../store";
import DataTable from "react-data-table-component";
import {columns} from "./columns";

function _parseDate(date) {
    return ("0" + date.getDate()).slice(-2) + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear();
}

const DocumentsList = () => {
    const dispatch = useDispatch();
    const store = useSelector(state => state.invoices.documents);

    const [showToast, setShowToast] = useState(false);
    const [dateFilter, setDateFilter] = useState(null);

    useEffect(() => {
        dispatch(
            getData({
                params: {
                    generatedAt: dateFilter
                },
            })
        );
    }, [dispatch]);

    useEffect(() => {
        dispatch(
            getData({
                params: {
                    generatedAt: dateFilter ? _parseDate(dateFilter) : null,
                },
            })
        );
    }, [dateFilter]);

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
                                            options={{dateFormat: 'd-m-Y', mode: 'single', plugins: [new monthSelectPlugin({})]}}
                                            className="filter-date-range-input"
                                            onClose={date => setDateFilter(date[0])}
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
                                <DataTable
                                    columns={columns}
                                    data={store.data}
                                    responsive={true}
                                    className='react-dataTable'
                                />
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

export default DocumentsList;