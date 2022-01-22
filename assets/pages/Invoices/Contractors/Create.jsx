import React, {useState} from 'react';
import {Link, useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";

function Create() {
    const dispatch = useDispatch();
    const validationErrors = useSelector(state => state.companies.validationErrors);
    let errors = [];
    const [inputs, setInputs] = useState({
        name: null,
        identificationNumber: null,
        phoneNumber: null,
        email: null,
        street: null,
        city: null,
        zipCode: null,
    });
    const navigate = useNavigate();

    function handleChange(e) {
        const { name, value } = e.target;
        setInputs(inputs => ({ ...inputs, [name]: value === '' ? null : value }));
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(companiesActions.createCompany(inputs, navigate));
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
                            <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>Basic
                                Information
                            </div>
                            <form id="create-company-form" onSubmit={handleSubmit}>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="name" style={{marginBottom: '.5rem', fontWeight: 500}}>Company
                                                name</label>
                                            <input id="name" name="name" placeholder="Enter company name..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['name'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['name'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="identificationNumber"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Identification
                                                Number</label>
                                            <input id="identificationNumber" name="identificationNumber"
                                                   placeholder="Enter identification number..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['identificationNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['identificationNumber'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="phoneNumber"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Phone number</label>
                                            <input id="phoneNumber" name="phoneNumber"
                                                   placeholder="Enter company phone number..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['phoneNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['phoneNumber'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="email"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Email</label>
                                            <input id="email" name="email" placeholder="Enter company email..."
                                                   type="email" className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['email'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['email'].message}</span>
                                            }
                                        </div>
                                    </div>

                                    <div className="col-sm-6">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="street"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Street</label>
                                            <input id="street" name="street"
                                                   placeholder="Enter company location street..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['street'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['street'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="city"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>City</label>
                                            <input id="city" name="city" placeholder="Enter company location city..."
                                                   type="text" className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['city'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['city'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="zipCode"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Zip code</label>
                                            <input id="zipCode" name="zipCode"
                                                   placeholder="Enter company location zip code..." type="text"
                                                   className="form-control"
                                                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                   onChange={handleChange}
                                            />
                                            {errors['zipCode'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['zipCode'].message}</span>
                                            }
                                        </div>
                                    </div>
                                </div>

                                <div className="justify-content-end row">
                                    <div className="col-lg-12">
                                        <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}}
                                                id="create-company-button" value="Save Changes"/>
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