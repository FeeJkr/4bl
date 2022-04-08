import React, {useEffect, useState} from "react";
import BankAccountListElement from "./BankAccountListElement";
import {useDispatch, useSelector} from "react-redux";
import {bankAccountsActions} from "../../../../actions/invoices/bankAccounts/actions";
import Input from "../../../../components/Fields/Form/Input";
import SubmitButton from "../../../../components/Fields/Form/SubmitButton";
import {currencies} from "../../../../helpers/currencies";
import Select from "../../../../components/Fields/Form/Select";

export default function Create(props) {
    const {company, onChangeCreateMode} = props;
    const dispatch = useDispatch();
    const bankAccounts = useSelector(state => state.invoices.bankAccounts.all.items);
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

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(bankAccountsActions.createBankAccount(inputs));
    }

    function handleChange(event) {
        const {name, value} = event.target;

        setInputs(inputs => ({ ...inputs, [name]: value === '' ? null : value }));
    }

    function handleSelectChange(value, meta) {
        setInputs(inputs => ({ ...inputs, [meta.name]: value.value}));
    }

    const validationErrors = useSelector(state => state.invoices.bankAccounts.create.validationErrors);
    let errors = [];

    if (validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div className="row" style={{borderBottom: '1px solid #dee2e6', paddingBottom: '1rem'}}>
                    <div className="col-sm-6">
                        <Input
                            name="name"
                            label="Name"
                            placeholder="Enter name..."
                            type="text"
                            onChange={handleChange}
                            error={errors['name']}
                        />
                        <Select
                            name="currency"
                            label="Currency"
                            options={currencies}
                            onChange={handleSelectChange}
                            error={errors['currency']}
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
                        />
                        <Input
                            name="bankAccountNumber"
                            label="Bank Account Number"
                            placeholder="Enter bank account number..."
                            type="text"
                            onChange={handleChange}
                            error={errors['bankAccountNumber']}
                        />
                    </div>

                    <SubmitButton/>
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
                        changeMode={onChangeCreateMode}
                    />
                })}
                </tbody>
            </table>
        </>
    );
}