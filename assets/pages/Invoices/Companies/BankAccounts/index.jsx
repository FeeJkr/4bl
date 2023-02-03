import React, {useEffect, useState} from "react";
import {Modal} from "react-bootstrap";
import 'bootstrap/dist/css/bootstrap.min.css';
import Edit from "./edit";
import Create from "./create";
import BankAccountsList from "./list";
import {useSelector} from "react-redux";
import {clear} from "../store";
import {store as mainStore} from "../../../../reducers/store";

const BankAccountModal = (props) => {
    const company = props.company;

    if (company === null) {
        return <></>;
    }

    const store = useSelector(state => state.invoices.companies);

    const [onEditMode, setOnEditMode] = useState(false);

    useEffect(() => {
        setOnEditMode(store.selectedBankAccount !== null);
    }, [store.selectedBankAccount]);

    const hideModal = () => {
        mainStore.dispatch(clear());
    }

    return (
        <>
            <Modal show={props.showBankAccountsModal} size="xl" onHide={hideModal}>
                <Modal.Header closeButton>
                    <Modal.Title>{company.name}'s bank accounts</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {onEditMode
                        ? <Edit/>
                        : <Create/>
                    }

                    <BankAccountsList company={company}/>
                </Modal.Body>
            </Modal>
        </>
    );
}

export default BankAccountModal;