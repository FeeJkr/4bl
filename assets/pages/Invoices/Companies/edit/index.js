import React, {useEffect, useState} from 'react';
import {Link, useNavigate, useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {vatRejectionOptions} from "../vatRejectionOptions";
import Input from "../../../../components/Fields/Form/Input";
import Switch from "../../../../components/Fields/Form/Switch";
import Select from "../../../../components/Fields/Form/Select";
import SubmitButton from "../../../../components/Fields/Form/SubmitButton";
import {fields, placeholders, labels, handleChanges as helperHandleChanges} from "../../../../helpers/forms/invoices/companies";
import {Form as Address} from "../../Addresses/Form";
import {updateCompany, getCompanyData, getData} from "../store";
import toast from "react-hot-toast";
import axios from "axios";
import {companiesDictionary} from "../../../../helpers/routes/invoices/companies/dictionary";

const EditCompany = () => {
    const {id} = useParams();
    const dispatch = useDispatch();
    const navigate = useNavigate();

    useEffect(() => {
        axios.get(companiesDictionary.GET_ONE_URL.replace('{id}', id)).then(response => {
            setCompany(response.data);
        });
    }, []);

    const [company, setCompany] = useState(null);

    function handleChange(e) {
        const clonedCompany = {...company};

        helperHandleChanges(e, clonedCompany);
        setCompany({ ...clonedCompany });
    }

    function handleSelectChange(value, meta) {
        const clonedCompany = {...company};

        clonedCompany[meta.name] = value.value;
        setCompany({ ...clonedCompany });
    }

    function handleSubmit(e) {
        e.preventDefault();

        axios.post(companiesDictionary.UPDATE_URL.replace('{id}', company.id), {
            name: company.name,
            identificationNumber: company.identificationNumber,
            email: company.email,
            phoneNumber: company.phoneNumber,
            isVatPayer: company.isVatPayer,
            vatRejectionReason: company.vatRejectionReason,
            address: {
                street: company.address.street,
                city: company.address.city,
                zipCode: company.address.zipCode,
            }
        });
        dispatch(getData());
        navigate('/invoices/companies');
        toast.success('Company was updated!');
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
                                                error={null}
                                                defaultValue={company.name}
                                            />
                                            <Input
                                                type="text"
                                                name={fields.identificationNumber}
                                                label={labels[fields.identificationNumber]}
                                                placeholder={placeholders[fields.identificationNumber]}
                                                onChange={handleChange}
                                                error={null}
                                                defaultValue={company.identificationNumber}
                                            />
                                            <Input
                                                type="email"
                                                name={fields.email}
                                                label={labels[fields.email]}
                                                placeholder={placeholders[fields.email]}
                                                onChange={handleChange}
                                                error={null}
                                                defaultValue={company.email}
                                            />
                                            <Input
                                                type="text"
                                                name={fields.phoneNumber}
                                                label={labels[fields.phoneNumber]}
                                                placeholder={placeholders[fields.phoneNumber]}
                                                onChange={handleChange}
                                                error={null}
                                                defaultValue={company.phoneNumber}
                                            />
                                        </div>

                                        <div className="col-sm-6">
                                            <Address object={company.address} errors={[]} onChange={handleChange}/>
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

                                        {(company.isVatPayer === false) &&
                                            <Select
                                                name={fields.vatRejectionReason}
                                                label={labels[fields.vatRejectionReason]}
                                                options={vatRejectionOptions}
                                                onChange={handleSelectChange}
                                                error={null}
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
            </div>
            : <div>Loading</div>
    );
}

export default EditCompany;