import React, {useState} from "react";
import {useDispatch, useSelector} from "react-redux";
import Input from "../../../../../components/Fields/Form/Input";
import SubmitButton from "../../../../../components/Fields/Form/SubmitButton";
import {currencies} from "../../../../../helpers/currencies";
import Select from "../../../../../components/Fields/Form/Select";
import {store as mainStore} from "../../../../../reducers/store";
import {selectBankAccount, updateBankAccount} from "../../store";
import toast from "react-hot-toast";

const Edit = () => {
    const dispatch = useDispatch();
    const store = useSelector(state => state.invoices.companies);
    const [bankAccount, setBankAccount] = useState({...store.selectedBankAccount});

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(updateBankAccount(bankAccount));
        mainStore.dispatch(selectBankAccount(null));
        toast.success("Bank account was updated!");
    }

    function handleChange(event) {
        const {name, value} = event.target;

        if (name === 'id') {
            return;
        }

        setBankAccount(inputs => ({ ...inputs, [name]: value === '' ? null : value }));
    }

    function handleSelectChange(value, meta) {
        if (meta.name === 'id') {
            return;
        }

        setBankAccount(inputs => ({ ...inputs, [meta.name]: value.value}));
    }

    return (
        <>
            <div style={{marginBottom: '1rem'}}>
                <a onClick={() => mainStore.dispatch(selectBankAccount(null))} style={{fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-arrow-left"/> Back
                </a>
            </div>

            <form onSubmit={handleSubmit}>
                <div className="row">
                    <div className="col-sm-6">
                        <Input
                            name="name"
                            label="Name"
                            placeholder="Enter name..."
                            type="text"
                            onChange={handleChange}
                            error={null}
                            defaultValue={bankAccount.name}
                        />
                        <Select
                            name="currency"
                            label="Currency"
                            options={currencies}
                            onChange={handleSelectChange}
                            error={null}
                            defaultValue={bankAccount.currency}
                        />
                    </div>

                    <div className="col-sm-6">
                        <Input
                            name="bankName"
                            label="Bank Name"
                            placeholder="Enter bank name..."
                            type="text"
                            onChange={handleChange}
                            error={null}
                            defaultValue={bankAccount.bankName}
                        />
                        <Input
                            name="bankAccountNumber"
                            label="Bank Account Number"
                            placeholder="Enter bank account number..."
                            type="text"
                            onChange={handleChange}
                            error={null}
                            defaultValue={bankAccount.bankAccountNumber}
                        />
                    </div>

                    <SubmitButton/>
                </div>
            </form>
        </>
    );
}

export default Edit;