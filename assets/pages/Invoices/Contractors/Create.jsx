import React, {useState} from 'react';
import {Link, useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {fields, labels, placeholders, handleChanges as helperHandleChanges} from "../../../helpers/forms/invoices/contractors";
import Input from "../../../components/Fields/Form/Input";
import {Form as Address} from "../Addresses/Form";
import SubmitButton from "../../../components/Fields/Form/SubmitButton";

function Create() {
    const dispatch = useDispatch();
    const validationErrors = useSelector(state => state.invoices.contractors.create.validationErrors);
    let errors = [];
    const [inputs, setInputs] = useState({
        name: null,
        identificationNumber: null,
        address: {
            street: null,
            city: null,
            zipCode: null,
        },
    });
    const navigate = useNavigate();

    function handleChange(e) {
        helperHandleChanges(e, inputs);
        setInputs(inputs);
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(contractorsActions.createContractor(inputs, navigate));
    }

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (
        <div className="container-fluid">
            <div
                style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Create new</h4>
                <div>
                    <nav>
                        <ol className="breadcrumb m-0">
                            <li className="breadcrumb-item">
                                <Link to={'/invoices/contractors'}
                                   style={{textDecoration: 'none', color: '#495057'}}>Contractors</Link>
                            </li>
                            <li className="active breadcrumb-item">
                                <Link to={'/invoices/contractors/new'}
                                   style={{textDecoration: 'none', color: '#74788d'}}>Add Contractor</Link>
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
                                        />

                                        <Input
                                            type="text"
                                            name={fields.identificationNumber}
                                            label={labels[fields.identificationNumber]}
                                            placeholder={placeholders[fields.identificationNumber]}
                                            onChange={handleChange}
                                            error={errors[fields.identificationNumber]}
                                        />
                                    </div>

                                    <div className="col-sm-6">
                                        <Address onChange={handleChange} errors={errors} object={inputs.address}/>
                                    </div>
                                </div>

                                <SubmitButton/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export {Create};