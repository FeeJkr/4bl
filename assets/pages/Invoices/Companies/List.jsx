import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../../actions/invoices/companies/actions";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import CompanyListElement from "./CompanyListElement";
import BankAccountsModal from "./BankAccounts/BankAccountsModal";

function List() {
    const companies = useSelector(state => state.invoices.companies.all.items);

    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);
    const [activeCompany, setActiveCompany] = useState(null);
    const [showBankAccountsModal, setShowBankAccountsModal] = useState(false);

    useEffect(() => {
        dispatch(companiesActions.getAll());
    }, []);

    function handleOpenBankAccountsModal(company) {
        setShowBankAccountsModal(true);
        setActiveCompany(company);
    }

    return (
        <>
            <BankAccountsModal
                showBankAccountsModal={showBankAccountsModal}
                setShowBankAccountsModal={setShowBankAccountsModal}
                company={activeCompany}
            />

            <div className="container-fluid">
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Companies</h4>

                <div className="row">
                    <div className="col-12">
                        <div className="card">
                            <div className="card-body">
                                <div className="mb-2 row">
                                    <div className="col-md-12" style={{textAlign: 'right'}}>
                                        <Link to={'/invoices/companies/new'} className="button-create-new btn btn-success">
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
                                            <th>VAT Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table-companies-body">
                                        {companies && companies.map(function (company, key) {
                                            return <CompanyListElement
                                                key={key}
                                                number={++key}
                                                company={company}
                                                setShowToast={setShowToast}
                                                handleOpenBankAccountsModal={handleOpenBankAccountsModal}
                                            />
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
        </>
    );
}

export {List};