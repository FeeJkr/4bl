import React, {useEffect, useState} from "react";
import {Modal} from "react-bootstrap";
import 'bootstrap/dist/css/bootstrap.min.css';
import {useDispatch, useSelector} from "react-redux";
import {bankAccountsActions} from "../../../../actions/invoices/bankAccounts/actions";
import CompanyListElement from "../CompanyListElement";
import BankAccountListElement from "./BankAccountListElement";

export default function BankAccountsModal(props) {
    if (props.company === null) {
        return <></>;
    }

    const company = props.company;
    const bankAccounts = useSelector(state => state.invoices.bankAccounts.all.items);
    const editValidationErrors = useSelector(state => state.invoices.bankAccounts.update.validationErrors);
    const createValidationErrors = useSelector(state => state.invoices.bankAccounts.create.validationErrors);
    const dispatch = useDispatch();
    const [onEditMode, setOnEditMode] = useState(false);
    const [editableBankAccount, setEditableBankAccount] = useState(null);
    const [inputs, setInputs] = useState({
        companyId: company.id,
        name: null,
        currency: null,
        bankName: null,
        bankAccountNumber: null,
    });
    
    useEffect(() => {
        dispatch(bankAccountsActions.getAll(company.id));
    }, [company]);

    function changeMode(bankAccount) {
        setOnEditMode(true);
        setEditableBankAccount(bankAccount);
    }

    function hideModal() {
        props.setShowBankAccountsModal(false);
        setOnEditMode(false);
        setEditableBankAccount(null);
    }

    function handleEditSubmit(e) {
        e.preventDefault();

        dispatch(bankAccountsActions.updateBankAccount(editableBankAccount.id, editableBankAccount, setOnEditMode));
    }

    function handleCreateSubmit(e) {
        e.preventDefault();

        dispatch(bankAccountsActions.createBankAccount(inputs));
    }

    function handleEditChange(event) {
        const {name, value} = event.target;

        editableBankAccount[name] = value;
    }

    function handleCreateChange(event) {
        const {name, value} = event.target;

        setInputs(inputs => ({ ...inputs, [name]: value === '' ? null : value }));
    }

    let editErrors = [];

    if (editValidationErrors) {
        editValidationErrors.forEach(function (element) {
            editErrors[element.propertyPath] = element;
        });
    }

    let createErrors = [];

    if (createValidationErrors) {
        createValidationErrors.forEach(function (element) {
            createErrors[element.propertyPath] = element;
        });
    }

    return (
        <>
            <Modal show={props.showBankAccountsModal} size="lg" onHide={hideModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{company.name}'s bank accounts</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {onEditMode && editableBankAccount
                        // EDIT PART
                        ? <>
                            <div style={{marginBottom: '1rem'}}>
                                <a onClick={() => setOnEditMode(false)} style={{fontSize: '18 px', cursor: 'pointer'}}>
                                    <i className="bi bi-arrow-left"/> Back
                                </a>
                            </div>

                            <form onSubmit={handleEditSubmit}>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="name" style={{marginBottom: '.5rem', fontWeight: 500}}>Name</label>
                                            <input id="name" name="name" placeholder="Enter name..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   defaultValue={editableBankAccount.name}
                                                   onChange={handleEditChange}
                                            />
                                            {editErrors['name'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{editErrors['name'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="currency" style={{marginBottom: '.5rem', fontWeight: 500}}>Currency</label>
                                            <input id="currency" name="currency"
                                                   placeholder="Enter currency code..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   defaultValue={editableBankAccount.currency}
                                                   onChange={handleEditChange}
                                            />
                                            {editErrors['currency'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{editErrors['currency'].message}</span>
                                            }
                                        </div>
                                    </div>

                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="bankName"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Bank Name</label>
                                            <input id="bankName" name="bankName"
                                                   placeholder="Enter bank name..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   defaultValue={editableBankAccount.bankName}
                                                   onChange={handleEditChange}
                                            />
                                            {editErrors['bankName'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{editErrors['bankName'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="bankAccountNumber" style={{marginBottom: '.5rem', fontWeight: 500}}>Bank Account Number</label>
                                            <input id="bankAccountNumber" name="bankAccountNumber"
                                                   placeholder="Enter bank account number..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   defaultValue={editableBankAccount.bankAccountNumber}
                                                   onChange={handleEditChange}
                                            />
                                            {editErrors['bankAccountNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{editErrors['bankAccountNumber'].message}</span>
                                            }
                                        </div>
                                    </div>

                                    <div className="justify-content-end row">
                                        <div className="col-lg-12">
                                            <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} value="Save Changes"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </>
                        // CREATE PART
                        : <>
                            <form onSubmit={handleCreateSubmit}>
                                <div className="row" style={{borderBottom: '1px solid #dee2e6', paddingBottom: '1rem'}}>
                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="name" style={{marginBottom: '.5rem', fontWeight: 500}}>Name</label>
                                            <input id="name" name="name" placeholder="Enter name..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleCreateChange}
                                            />
                                            {createErrors['name'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{createErrors['name'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="currency" style={{marginBottom: '.5rem', fontWeight: 500}}>Currency</label>
                                            <input id="currency" name="currency"
                                                   placeholder="Enter currency code..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleCreateChange}
                                            />
                                            {createErrors['currency'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{createErrors['currency'].message}</span>
                                            }
                                        </div>
                                    </div>

                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="bankName"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Bank Name</label>
                                            <input id="bankName" name="bankName"
                                                   placeholder="Enter bank name..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleCreateChange}
                                            />
                                            {createErrors['bankName'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{createErrors['bankName'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="bankAccountNumber" style={{marginBottom: '.5rem', fontWeight: 500}}>Bank Account Number</label>
                                            <input id="bankAccountNumber" name="bankAccountNumber"
                                                   placeholder="Enter bank account number..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleCreateChange}
                                            />
                                            {createErrors['bankAccountNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{createErrors['bankAccountNumber'].message}</span>
                                            }
                                        </div>
                                    </div>

                                    <div className="justify-content-end row">
                                        <div className="col-lg-12">
                                            <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} value="Save Changes"/>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <table className="table align-middle table-nowrap table-check" style={{marginTop: '1rem'}}>
                                <thead className="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="table-companies-body">
                                {bankAccounts && bankAccounts.map(function (bankAccount, key) {
                                    return <BankAccountListElement
                                        key={key}
                                        number={++key}
                                        bankAccount={bankAccount}
                                        changeMode={changeMode}
                                    />
                                })}
                                </tbody>
                            </table>
                        </>
                    }
                </Modal.Body>
            </Modal>
        </>
    );
}