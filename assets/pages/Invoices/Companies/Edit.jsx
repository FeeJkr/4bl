import React, {useEffect} from 'react';
import {Link, useParams} from 'react-router-dom';
import {companiesActions} from "../../../actions/companies.actions";
import {useDispatch, useSelector} from "react-redux";
import {Toast} from "react-bootstrap";

function Edit() {
    const company = useSelector(state => state.companies.company);
    let successUpdateBasicInformation = useSelector(state => state.companies.successUpdateBasicInformation);
    let successUpdatePaymentInformation = useSelector(state => state.companies.successUpdatePaymentInformation);
    const dispatch = useDispatch();
    const {id} = useParams();
    const validationErrors = useSelector(state => state.companies.validationErrors);
    let errors = [];

    useEffect(() => {
        dispatch(companiesActions.getOne(id));
    }, []);

    function handleChange(e) {
        const { name, value } = e.target;
        company[name] = value;
    }

    function handleBasicInformationSubmit(e) {
        e.preventDefault();

        dispatch(companiesActions.updateCompanyBasicInformation(id, company));
    }


    function handlePaymentInformationSubmit(e) {
        e.preventDefault();

        dispatch(companiesActions.updateCompanyPaymentInformation(id, company));
    }

    function closeToast() {
        dispatch(companiesActions.clearAlerts());
    }

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
                    <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>
                        Edit {company.name}
                    </h4>
                    <div>
                        <nav>
                            <ol className="breadcrumb m-0">
                                <li className="breadcrumb-item">
                                    <Link to="/invoices/companies"
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
                                <div className="mb-4"
                                     style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}
                                >
                                    Basic Information
                                </div>
                                <form onSubmit={handleBasicInformationSubmit}>
                                    <div className="row">
                                        <div className="col-sm-6">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="name" style={{marginBottom: '.5rem', fontWeight: 500}}>Company name</label>
                                                <input id="name" name="name" placeholder="Enter company name..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       defaultValue={company.name}
                                                       onChange={handleChange}
                                                />
                                                {errors['name'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['name'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="identificationNumber"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Identification Number</label>
                                                <input id="identificationNumber" name="identificationNumber"
                                                       placeholder="Enter identification number..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       defaultValue={company.identificationNumber}
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
                                                       defaultValue={company.phoneNumber}
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
                                                       defaultValue={company.email}
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
                                                       defaultValue={company.street}
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
                                                       defaultValue={company.city}
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
                                                       defaultValue={company.zipCode}
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
                                            <input type="submit"
                                                   className="btn btn-primary"
                                                   style={{fontSize: '13px'}}
                                                   value='Save Changes'
                                            />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="card">
                    <div className="card-body">
                        <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>
                            Payment Information
                        </div>
                        <form onSubmit={handlePaymentInformationSubmit}>
                            <div className="row">
                                <div className="col-sm-6">
                                    <div className="mb-3 form-group">
                                        <label htmlFor="paymentType"
                                               style={{marginBottom: '.5rem', fontWeight: 500}}>Payment type</label>
                                        <input id="paymentType" name="paymentType" placeholder="Enter payment type..."
                                               type="text" className="form-control"
                                               style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                               defaultValue={company.paymentType}
                                               onChange={handleChange}
                                        />
                                        {errors['paymentType'] &&
                                            <span style={{color: 'red', fontSize: '10px'}}>{errors['paymentType'].message}</span>
                                        }
                                    </div>
                                    <div className="mb-3 form-group">
                                        <label htmlFor="paymentLastDate"
                                               style={{marginBottom: '.5rem', fontWeight: 500}}>Days For Payment After Sell</label>
                                        <input id="paymentLastDate" name="paymentLastDate"
                                               placeholder="Enter days for payment after sell date..." type="number"
                                               className="form-control"
                                               style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                               defaultValue={company.paymentLastDate}
                                               onChange={handleChange}
                                        />
                                        {errors['paymentLastDate'] &&
                                            <span style={{color: 'red', fontSize: '10px'}}>{errors['paymentLastDate'].message}</span>
                                        }
                                    </div>
                                </div>

                                <div className="col-sm-6">
                                    <div className="mb-3 form-group">
                                        <label htmlFor="bank" style={{marginBottom: '.5rem', fontWeight: 500}}>Bank</label>
                                        <input id="bank" name="bank" placeholder="Enter bank name..." type="text"
                                               className="form-control"
                                               style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                               defaultValue={company.bank}
                                               onChange={handleChange}
                                        />
                                        {errors['bank'] &&
                                            <span style={{color: 'red', fontSize: '10px'}}>{errors['bank'].message}</span>
                                        }
                                    </div>
                                    <div className="mb-3 form-group">
                                        <label htmlFor="accountNumber"
                                               style={{marginBottom: '.5rem', fontWeight: 500}}>Account number</label>
                                        <input id="accountNumber" name="accountNumber" placeholder="Enter account number..."
                                               type="text" className="form-control"
                                               style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                               defaultValue={company.accountNumber}
                                               onChange={handleChange}
                                        />
                                        {errors['accountNumber'] &&
                                            <span style={{color: 'red', fontSize: '10px'}}>{errors['accountNumber'].message}</span>
                                        }
                                    </div>
                                </div>
                            </div>

                            <div className="justify-content-end row">
                                <div className="col-lg-12">
                                    <input type="submit"
                                           className="btn btn-primary"
                                           style={{fontSize: '13px'}}
                                           value='Save Changes'
                                    />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div style={{position: 'absolute', bottom: 80, right: 20}}>
                    <Toast style={{backgroundColor: '#00ca72'}}
                           onClose={closeToast}
                           show={!!successUpdateBasicInformation}
                           delay={3000}
                           autohide
                    >
                        <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                            <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                        </Toast.Header>
                        <Toast.Body style={{color: '#fff'}}>
                            Company basic information was successfully updated.
                        </Toast.Body>
                    </Toast>

                    <Toast style={{backgroundColor: '#00ca72'}}
                           onClose={closeToast}
                           show={!!successUpdatePaymentInformation}
                           delay={3000}
                           autohide
                    >
                        <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                            <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                        </Toast.Header>
                        <Toast.Body style={{color: '#fff'}}>
                            Company payment information was successfully updated.
                        </Toast.Body>
                    </Toast>
                </div>

            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};