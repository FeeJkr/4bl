import React from "react";
import {useDispatch, useSelector} from "react-redux";
import {bankAccountsActions} from "../../../../actions/invoices/bankAccounts/actions";
import Input from "../../../../components/Fields/Form/Input";
import SubmitButton from "../../../../components/Fields/Form/SubmitButton";
import {currencies} from "../../../../helpers/currencies";
import Select from "../../../../components/Fields/Form/Select";

export default function Edit(props) {
    const dispatch = useDispatch();
    const {bankAccount, onChangeEditMode} = props;

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(bankAccountsActions.updateBankAccount(bankAccount.id, bankAccount, onChangeEditMode));
    }

    function handleChange(event) {
        const {name, value} = event.target;

        bankAccount[name] = value;
    }

    function handleSelectChange(value, meta) {
        bankAccount[meta.name] = value.value;
    }

    const validationErrors = useSelector(state => state.invoices.bankAccounts.update.validationErrors);
    let errors = [];

    if (validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (
        <>
            <div style={{marginBottom: '1rem'}}>
                <a onClick={() => onChangeEditMode(false)} style={{fontSize: '18 px', cursor: 'pointer'}}>
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
                            error={errors['name']}
                            defaultValue={bankAccount.name}
                        />
                        <Select
                            name="currency"
                            label="Currency"
                            options={currencies}
                            onChange={handleSelectChange}
                            error={errors['currency']}
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
                            error={errors['bankName']}
                            defaultValue={bankAccount.bankName}
                        />
                        <Input
                            name="bankAccountNumber"
                            label="Bank Account Number"
                            placeholder="Enter bank account number..."
                            type="text"
                            onChange={handleChange}
                            error={errors['bankAccountNumber']}
                            defaultValue={bankAccount.bankAccountNumber}
                        />
                    </div>

                    <SubmitButton/>
                </div>
            </form>
        </>
    );
}
