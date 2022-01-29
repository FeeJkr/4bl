import React, {useEffect} from 'react';
import {Link, useParams} from 'react-router-dom';
import {contractorsActions} from "../../../actions/invoices/contractors/actions";
import {useDispatch, useSelector} from "react-redux";
import {Toast} from "react-bootstrap";

function Edit() {
    const dispatch = useDispatch();
    const contractor = useSelector(state => state.invoices.contractors.one.item);
    const validationErrors = useSelector(state => state.invoices.contractors.update.validationErrors);
    const isUpdated = useSelector(state => state.invoices.contractors.update.isUpdated);
    const {id} = useParams();
    let errors = [];

    useEffect(() => {
        dispatch(contractorsActions.getOneById(id));
    }, []);

    function handleChange(e) {
        const { name, value } = e.target;

        if (['street', 'city', 'zipCode'].includes(name)) {
            contractor.address[name] = value === '' ? null : value;
        } else {
            contractor[name] = value === '' ? null : value;
        }
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(contractorsActions.updateContractor(id, contractor));
    }

    function closeToast() {
        dispatch(contractorsActions.clearAlerts());
    }

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
                                <div className="mb-4"
                                     style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}
                                >
                                    Basic Information
                                </div>
                                <form onSubmit={handleSubmit}>
                                    <div className="row">
                                        <div className="col-sm-6">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="name" style={{marginBottom: '.5rem', fontWeight: 500}}>Company name</label>
                                                <input id="name" name="name" placeholder="Enter company name..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       defaultValue={contractor.name}
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
                                                       defaultValue={contractor.identificationNumber}
                                                       onChange={handleChange}
                                                />
                                                {errors['identificationNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['identificationNumber'].message}</span>
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
                                                       defaultValue={contractor.address.street}
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
                                                       defaultValue={contractor.address.city}
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
                                                       defaultValue={contractor.address.zipCode}
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

                <div style={{position: 'absolute', bottom: 80, right: 20}}>
                    <Toast style={{backgroundColor: '#00ca72'}}
                           onClose={closeToast}
                           show={!!isUpdated}
                           delay={3000}
                           autohide
                    >
                        <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                            <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                        </Toast.Header>
                        <Toast.Body style={{color: '#fff'}}>
                            Contractor's information was successfully updated.
                        </Toast.Body>
                    </Toast>
                </div>

            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};