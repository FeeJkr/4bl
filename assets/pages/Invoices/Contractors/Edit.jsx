import React, {useEffect} from 'react';
import {Link, useParams} from 'react-router-dom';
import {useDispatch, useSelector} from "react-redux";
import {fields, labels, placeholders, handleChanges as helperHandleChanges} from "../../../helpers/forms/invoices/contractors";
import Input from "../../../components/Fields/Form/Input";
import {Form as Address} from "../Addresses/Form";
import SubmitButton from "../../../components/Fields/Form/SubmitButton";
import SuccessAlert from "../../../components/Fields/Form/SuccessAlert";

function Edit() {
    const {id} = useParams();
    const dispatch = useDispatch();
    const contractor = useSelector(state => state.invoices.contractors.one.item);
    const isUpdated = useSelector(state => state.invoices.contractors.update.isUpdated);

    useEffect(() => {
        dispatch(contractorsActions.getOneById(id));
    }, []);

    function handleChange(e) {
        helperHandleChanges(e, contractor);
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(contractorsActions.updateContractor(id, contractor));
    }

    const validationErrors = useSelector(state => state.invoices.contractors.update.validationErrors);
    let errors = [];

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (contractor
        ?
            <div className="container-fluid">
                <div
                    style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                    <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>
                        Edit {contractor.name}
                    </h4>
                    <div>
                        <nav>
                            <ol className="breadcrumb m-0">
                                <li className="breadcrumb-item">
                                    <Link to="/invoices/contractors"
                                       style={{textDecoration: 'none', color: '#495057'}}>Contractors</Link>
                                </li>
                                <li className="active breadcrumb-item">
                                    <Link to={'/invoices/contractors/' + contractor.id}
                                       style={{textDecoration: 'none', color: '#74788d'}}>Edit Contractor</Link>
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
                                <form onSubmit={handleSubmit}>
                                    <div className="row">
                                        <div className="col-sm-6">
                                            <Input
                                                type="text"
                                                name={fields.name}
                                                label={labels[fields.name]}
                                                placeholder={placeholders[fields.name]}
                                                onChange={handleChange}
                                                error={errors[fields.name]}
                                                defaultValue={contractor.name}
                                            />

                                            <Input
                                                type="text"
                                                name={fields.identificationNumber}
                                                label={labels[fields.identificationNumber]}
                                                placeholder={placeholders[fields.identificationNumber]}
                                                onChange={handleChange}
                                                error={errors[fields.identificationNumber]}
                                                defaultValue={contractor.identificationNumber}
                                            />
                                        </div>
                                        <div className="col-sm-6">
                                            <Address onChange={handleChange} errors={errors} object={contractor.address}/>
                                        </div>
                                    </div>

                                    <SubmitButton/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <SuccessAlert
                    onClose={() => dispatch(contractorsActions.clearAlerts())}
                    show={!!isUpdated}
                    text="Contractor's information was successfully updated."
                />
            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};