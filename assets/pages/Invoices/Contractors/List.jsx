import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {contractorsActions} from "../../../actions/invoices/contractors/actions";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import ContractorListElement from "./ContractorListElement";

function List() {
    const contractors = useSelector(state => state.invoices.contractors.all.items);

    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);

    useEffect(() => {
        dispatch(contractorsActions.getAll());
    }, []);

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Contractors</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right'}}>
                                    <Link to={'/invoices/contractors/new'} className="button-create-new btn btn-success"
                                            id="button-create-new-contractor">
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
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-companies-body">
                                    {contractors && contractors.map(function (contractor, key) {
                                        return <ContractorListElement
                                            key={key}
                                            number={++key}
                                            contractor={contractor}
                                            setShowToast={setShowToast}
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
                    Contractor was successfully deleted.
                </Toast.Body>
            </Toast>
        </div>
    );
}

export {List};