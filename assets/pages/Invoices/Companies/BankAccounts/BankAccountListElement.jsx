import React, {useState} from 'react';
import {bankAccountsActions} from "../../../../actions/invoices/bankAccounts/actions";
import {useDispatch} from "react-redux";

export default function BankAccountListElement(props) {
    const dispatch = useDispatch();
    const bankAccount = props.bankAccount;

    function handleDelete(id, companyId) {
        dispatch(bankAccountsActions.deleteBankAccount(id, companyId));
    }

    return (
        <tr key={bankAccount.id}>
            <th scope="row">{props.number}</th>
            <td>{bankAccount.name}</td>
            <td>{bankAccount.bankName}</td>
            <td>{bankAccount.bankAccountNumber}</td>
            <td>{bankAccount.currency}</td>
            <td>
                <div className="gap-3" style={{display: 'flex', gridGap: '1 rem'}}>
                    <a onClick={() => props.changeMode(bankAccount)} style={{color: '#34c38f', fontSize: '18 px', cursor: 'pointer'}}>
                        <i className="bi bi-pencil"
                           style={{color: '#34c38f'}}
                        />
                    </a>
                    <a onClick={() => handleDelete(bankAccount.id, bankAccount.companyId)}
                       style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                        <i className="bi bi-trash"
                           style={{color: '#f46a6a'}}
                        />
                    </a>
                </div>
            </td>
        </tr>
    );
}