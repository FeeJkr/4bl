import React, {useState} from "react";
import Input from "../../../../../components/Fields/Form/Input";
import SubmitButton from "../../../../../components/Fields/Form/SubmitButton";
import {currencies} from "../../../../../helpers/currencies";
import Select from "../../../../../components/Fields/Form/Select";
import {useDispatch, useSelector} from "react-redux";
import {addBankAccount} from "../../store";
import toast from "react-hot-toast";

const Create = () => {
    const dispatch = useDispatch();
    const store = useSelector(state => state.invoices.companies);

    const [inputs, setInputs] = useState({
        companyId: store.selectedCompany.id,
        name: null,
        currency: null,
        bankName: null,
        bankAccountNumber: null,
    });

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(addBankAccount(inputs));
        toast.success("Bank account was created!");
    }

    function handleChange(event) {
        const {name, value} = event.target;

        setInputs(inputs => ({ ...inputs, [name]: value === '' ? null : value }));
    }

    function handleSelectChange(value, meta) {
        setInputs(inputs => ({ ...inputs, [meta.name]: value.value}));
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
                            error={null}
                        />
                        <Select
                            name="currency"
                            label="Currency"
                            options={currencies}
                            onChange={handleSelectChange}
                            error={null}
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
                        />
                        <Input
                            name="bankAccountNumber"
                            label="Bank Account Number"
                            placeholder="Enter bank account number..."
                            type="text"
                            onChange={handleChange}
                            error={null}
                        />
                    </div>

                    <SubmitButton/>
                </div>
            </form>
        </>
    );
}

export default Create;