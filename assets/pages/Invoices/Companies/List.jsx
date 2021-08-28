import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../../actions/companies.actions";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";

function List() {
    const companies = useSelector(state => state.companies.items);
    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);

    useEffect(() => {
        dispatch(companiesActions.getAll());
    }, []);

    function handleDelete(id) {
        dispatch(companiesActions.deleteCompany(id));
        setShowToast(true);
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Companies</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right'}}>
                                    <Link to={'/invoices/companies/new'} className="button-create-new btn btn-success"
                                            id="button-create-new-company">
                                        <i className="bi bi-plus"/>
                                        Create new
                                    </Link>
                                </div>
                            </div>

                            <div>
                                <table className="table align-middle table-nowrap table-check">
                                    <thead className="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Identification Number</th>
                                        <th>Address</th>
                                        <th width="100px">Payment Information</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-companies-body">
                                    {companies && companies.map(function (company, key) {
                                        return (
                                            <tr key={company.id}>
                                                <th scope="row">{++key}</th>
                                                <td>{company.name}</td>
                                                <td>{company.identificationNumber}</td>
                                                <td>{company.street}, {company.zipCode} {company.city}</td>
                                                <td align="center">
                                                    {company.paymentType
                                                        ? (<i className="bi bi-check-circle" style={{color: '#34c38f', fontSize: '18px'}}/>)
                                                        : (<i className="bi bi-x-circle" style={{color: '#f46a6a', fontSize: '18px'}}/>)
                                                    }
                                                </td>
                                                <td>
                                                    <div className="gap-3"
                                                         style={{display: 'flex', gridGap: '1 rem'}}>
                                                        <Link to={'/invoices/companies/edit/' + company.id}>
                                                            <i className="bi bi-pencil edit-company-button"
                                                                style={{color: '#34c38f'}}
                                                            />
                                                        </Link>
                                                        <a onClick={() => handleDelete(company.id)}
                                                              style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                                                            <i className="bi bi-trash delete-company-button"
                                                                style={{color: '#f46a6a'}}
                                                            />
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                    </tbody>
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
                    Company was successfully deleted.
                </Toast.Body>
            </Toast>
        </div>
    );
}

export {List};