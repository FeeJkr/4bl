import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {companiesActions} from "../../../actions/invoices/companies/actions";
import {useDispatch} from "react-redux";

export default function CompanyListElement(props) {
    const dispatch = useDispatch();
    const company = props.company;
    let number = 0;
    const currentAddress = props.addresses
        ? props.addresses.find((address) => company.addressId === address.id)
        : null;

    function handleDelete(id) {
        dispatch(companiesActions.deleteCompany(id));
        props.setShowToast(true);
    }

    return (
        <tr key={company.id}>
            <th scope="row">{++number}</th>
            <td>{company.name}</td>
            <td>{company.identificationNumber}</td>
            <td>{currentAddress &&
                <> {currentAddress.street}, {currentAddress.city}, {currentAddress.zipCode} </>
            }</td>
            <td>
                {company.isVatPayer}
            </td>
            <td>
                <div className="gap-3"
                     style={{display: 'flex', gridGap: '1 rem'}}>
                    <Link to={'/invoices/contractors/edit/' + company.id}>
                        <i className="bi bi-pencil edit-contractors-button"
                           style={{color: '#34c38f'}}
                        />
                    </Link>
                    <a onClick={() => handleDelete(company.id)}
                       style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                        <i className="bi bi-trash delete-contractors-button"
                           style={{color: '#f46a6a'}}
                        />
                    </a>
                </div>
            </td>
        </tr>
    );
}