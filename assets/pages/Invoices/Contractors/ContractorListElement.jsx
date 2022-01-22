import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {contractorsActions} from "../../../actions/invoices/contractors/actions";
import {useDispatch} from "react-redux";

export default function ContractorListElement(props) {
    const dispatch = useDispatch();
    const contractor = props.contractor;
    let number = 0;
    const currentAddress = props.addresses
        ? props.addresses.find((address) => contractor.addressId === address.id)
        : null;

    function handleDelete(id) {
        dispatch(contractorsActions.deleteContractor(id));
        props.setShowToast(true);
    }

    return (
        <tr key={contractor.id}>
            <th scope="row">{++number}</th>
            <td>{contractor.name}</td>
            <td>{contractor.identificationNumber}</td>
            <td>{currentAddress &&
                <> {currentAddress.street}, {currentAddress.city}, {currentAddress.zipCode} </>
            }</td>
            <td>
                <div className="gap-3"
                     style={{display: 'flex', gridGap: '1 rem'}}>
                    <Link to={'/invoices/contractors/edit/' + contractor.id}>
                        <i className="bi bi-pencil edit-contractors-button"
                           style={{color: '#34c38f'}}
                        />
                    </Link>
                    <a onClick={() => handleDelete(contractor.id)}
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