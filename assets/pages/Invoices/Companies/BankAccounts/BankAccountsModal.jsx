import React, {useState} from "react";
import {Modal} from "react-bootstrap";
import 'bootstrap/dist/css/bootstrap.min.css';
import Edit from "./Edit";
import Create from "./Create";

export default function BankAccountsModal(props) {
    const company = props.company;

    if (company === null) {
        return <></>;
    }

    const [onEditMode, setOnEditMode] = useState(false);
    const [editableBankAccount, setEditableBankAccount] = useState(null);

    const hideModal = () => {
        props.setShowBankAccountsModal(false);
        setOnEditMode(false);
        setEditableBankAccount(null);
    }

    const changeMode = (bankAccount) => {
        setOnEditMode(true);
        setEditableBankAccount(bankAccount);
    }

    return (
        <>
            <Modal show={props.showBankAccountsModal} size="lg" onHide={hideModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{company.name}'s bank accounts</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {onEditMode && editableBankAccount
                        ? <Edit bankAccount={editableBankAccount} onChangeEditMode={setOnEditMode}/>
                        : <Create company={company} onChangeCreateMode={changeMode}/>
                    }
                </Modal.Body>
            </Modal>
        </>
    );
}