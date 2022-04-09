import React, {useEffect, useState} from 'react';
import {Link, useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {companiesActions} from "../../../actions/invoices/companies/actions";
import {vatRejectionOptions} from "./vatRejectionOptions";
import Input from "../../../components/Fields/Form/Input";
import Switch from "../../../components/Fields/Form/Switch";
import Select from "../../../components/Fields/Form/Select";
import SuccessAlert from "../../../components/Fields/Form/SuccessAlert";
import SubmitButton from "../../../components/Fields/Form/SubmitButton";
import {fields, placeholders, labels, handleChanges as helperHandleChanges} from "../../../helpers/forms/invoices/companies";
import {Form as Address} from "../Addresses/Form";

function Edit() {
    const {id} = useParams();
    const dispatch = useDispatch();
    const company = useSelector(state => state.invoices.companies.one.item);
    const isUpdated = useSelector(state => state.invoices.companies.update.isUpdated);
    const [isVatPayer, setIsVatPayer] = useState(null);

    useEffect(() => {
        dispatch(companiesActions.getOneById(id));
    }, []);

    function handleChange(e) {
        helperHandleChanges(e, company);
        setIsVatPayer(company.isVatPayer);
    }

    function handleSelectChange(value, meta) {
        company[meta.name] = value.value;
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(companiesActions.updateCompany(id, company));
    }

    const validationErrors = useSelector(state => state.invoices.companies.update.validationErrors);
    let errors = [];

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (company
        ?
        <div className="container-fluid">
            <div
                style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Edit {company.name}</h4>
                <div>
                    <nav>
                        <ol className="breadcrumb m-0">
                            <li className="breadcrumb-item">
                                <Link to={'/invoices/companies'}
                                      style={{textDecoration: 'none', color: '#495057'}}>Companies</Link>
                            </li>
                            <li className="active breadcrumb-item">
                                <Link to={'/invoices/companies/' + company.id}
                                      style={{textDecoration: 'none', color: '#74788d'}}>Edit Company</Link>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>Basic
                                Information
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
                                            defaultValue={company.name}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.identificationNumber}
                                            label={labels[fields.identificationNumber]}
                                            placeholder={placeholders[fields.identificationNumber]}
                                            onChange={handleChange}
                                            error={errors[fields.identificationNumber]}
                                            defaultValue={company.identificationNumber}
                                        />
                                        <Input
                                            type="email"
                                            name={fields.email}
                                            label={labels[fields.email]}
                                            placeholder={placeholders[fields.email]}
                                            onChange={handleChange}
                                            error={errors[fields.email]}
                                            defaultValue={company.email}
                                        />
                                        <Input
                                            type="text"
                                            name={fields.phoneNumber}
                                            label={labels[fields.phoneNumber]}
                                            placeholder={placeholders[fields.phoneNumber]}
                                            onChange={handleChange}
                                            error={errors[fields.phoneNumber]}
                                            defaultValue={company.phoneNumber}
                                        />
                                    </div>

                                    <div className="col-sm-6">
                                        <Address object={company.address} errors={errors} onChange={handleChange}/>
                                    </div>
                                </div>

                                <hr/>

                                <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>Tax information</div>

                                <div className="row">
                                    <Switch
                                        name={fields.isVatPayer}
                                        label={labels[fields.isVatPayer]}
                                        onChange={handleChange}
                                        defaultChecked={company.isVatPayer}
                                    />

                                    {(isVatPayer === false || company.isVatPayer === false) &&
                                        <Select
                                            name={fields.vatRejectionReason}
                                            label={labels[fields.vatRejectionReason]}
                                            options={vatRejectionOptions}
                                            onChange={handleSelectChange}
                                            error={errors[fields.vatRejectionReason]}
                                            defaultValue={company.vatRejectionReason}
                                        />
                                    }
                                </div>

                                <SubmitButton/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <SuccessAlert
                show={!!isUpdated}
                onClose={() => dispatch(companiesActions.clearAlerts())}
                text="Company information was successfully updated."
            />
        </div>
        : <div>Loading</div>
    );
}

export {Edit};