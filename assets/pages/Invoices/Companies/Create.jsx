import React, {useState} from 'react';
import {Link, useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../../actions/invoices/companies/actions";
import {vatRejectionOptions} from "./vatRejectionOptions";
import Input from "../../../components/Fields/Form/Input";
import Switch from "../../../components/Fields/Form/Switch";
import Select from "../../../components/Fields/Form/Select";
import {fields, placeholders, labels, handleChanges as helperHandleChanges} from "../../../helpers/forms/invoices/companies";

function Create() {
    const navigate = useNavigate();
    const dispatch = useDispatch();
    const [inputs, setInputs] = useState({
        [fields.name]: null,
        [fields.identificationNumber]: null,
        [fields.email]: null,
        [fields.phoneNumber]: null,
        [fields.isVatPayer]: false,
        [fields.vatRejectionReason]: null,
        [fields.address]: {
            [fields.street]: null,
            [fields.city]: null,
            [fields.zipCode]: null,
        },
    });

    function handleChange(e) {
        helperHandleChanges(e, inputs);
        setInputs(inputs);
    }

    function handleSelectChange(value, meta) {
        setInputs(inputs => ({ ...inputs, [fields[meta.name]]: value.value}));
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(companiesActions.createCompany(inputs, navigate));
    }

    const validationErrors = useSelector(state => state.invoices.companies.create.validationErrors);
    let errors = [];

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (
        <div className="container-fluid">
            <div style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Create new</h4>
                <div>
                    <nav>
                        <ol className="breadcrumb m-0">
                            <li className="breadcrumb-item">
                                <Link to={'/invoices/companies'}
                                   style={{textDecoration: 'none', color: '#495057'}}>Companies</Link>
                            </li>
                            <li className="active breadcrumb-item">
                                <Link to={'/invoices/companies/new'}
                                   style={{textDecoration: 'none', color: '#74788d'}}>Add Company</Link>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>
                                Basic Information
                            </div>
                            <form id="create-contractor-form" onSubmit={handleSubmit}>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <Input
                                            type="text"
                                            name={fields.name}
                                            label={labels[fields.name]}
                                            placeholder={placeholders[fields.name]}
                                            onChange={handleChange}
                                            error={errors[fields.name]}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.identificationNumber}
                                            label={labels[fields.identificationNumber]}
                                            placeholder={placeholders[fields.identificationNumber]}
                                            onChange={handleChange}
                                            error={errors[fields.identificationNumber]}
                                        />
                                        <Input
                                            type="email"
                                            name={fields.email}
                                            label={labels[fields.email]}
                                            placeholder={placeholders[fields.email]}
                                            onChange={handleChange}
                                            error={errors[fields.email]}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.phoneNumber}
                                            label={labels[fields.phoneNumber]}
                                            placeholder={placeholders[fields.phoneNumber]}
                                            onChange={handleChange}
                                            error={errors[fields.phoneNumber]}
                                        />
                                    </div>

                                    <div className="col-sm-6">
                                        <Input
                                            type="text"
                                            name={fields.street}
                                            label={labels[fields.street]}
                                            placeholder={placeholders[fields.street]}
                                            onChange={handleChange}
                                            error={errors[fields.street]}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.city}
                                            label={labels[fields.city]}
                                            placeholder={placeholders[fields.city]}
                                            onChange={handleChange}
                                            error={errors[fields.city]}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.zipCode}
                                            label={labels[fields.zipCode]}
                                            placeholder={placeholders[fields.zipCode]}
                                            onChange={handleChange}
                                            error={errors[fields.zipCode]}
                                        />
                                    </div>
                                </div>

                                <hr/>

                                <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>
                                    Tax information
                                </div>

                                <div className="row">
                                    <Switch
                                        name={fields.isVatPayer}
                                        label={labels[fields.isVatPayer]}
                                        onChange={handleChange}
                                    />

                                    {!inputs.isVatPayer &&
                                        <Select
                                            name={fields.vatRejectionReason}
                                            label={labels[fields.vatRejectionReason]}
                                            options={vatRejectionOptions}
                                            onChange={handleSelectChange}
                                            error={errors[fields.vatRejectionReason]}
                                        />
                                    }
                                </div>

                                <div className="justify-content-end row">
                                    <div className="col-lg-12">
                                        <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} id="create-company-button" value="Save Changes"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export {Create};