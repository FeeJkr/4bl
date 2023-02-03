import React, {useEffect, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
import {Link} from "react-router-dom";
import DataTable from "react-data-table-component";
import BankAccountModal from "../BankAccounts";
import {columns} from "./columns";
import {getData} from "../store";
const CompaniesList = () => {
    const dispatch = useDispatch();
    const store = useSelector(state => state.invoices.companies);

    const [showBankAccountsModal, setShowBankAccountsModal] = useState(false);

    useEffect(() => {
        dispatch(getData());
    }, [dispatch]);

    useEffect(() => {
        setShowBankAccountsModal(store.selectedCompany !== null);
    }, [store.selectedCompany]);

    return (
        <div>
            <BankAccountModal
                showBankAccountsModal={showBankAccountsModal}
                setShowBankAccountsModal={setShowBankAccountsModal}
                company={store.selectedCompany}
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
                                    <DataTable
                                        pagination
                                        sortServer
                                        paginationServer
                                        columns={columns}
                                        responsive={true}
                                        data={store.data}
                                        defaultSortField='id'
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default CompaniesList;