import React, {useEffect, useState} from 'react';
import {Link, useParams} from 'react-router-dom';
import {invoicesActions} from "../../../actions/invoices.actions";
import {useDispatch, useSelector} from "react-redux";
import Flatpickr from "react-flatpickr";
import Select from "react-select";
import {DragDropContext, Draggable, Droppable} from "react-beautiful-dnd";
import './Invoices.css';
import 'boxicons/css/boxicons.min.css';
import {companiesActions} from "../../../actions/invoices/companies/actions";
import AsyncSelect from "react-select/async";
import {contractorsService} from "../../../services/invoices/contractors/crud.service";

function Edit() {
    const {id} = useParams();
    const dispatch = useDispatch();
    const invoice = useSelector(state => state.invoices.documents.one.item);
    const isLoading = useSelector(state => state.invoices.documents.update.isLoading);
    const isUpdated = useSelector(state => state.invoices.documents.update.isUpdated);
    const validationErrors = useSelector(state => state.invoices.documents.update.validationErrors);
    const companies = useSelector(state => state.invoices.companies.all.items);
    const [seller, setSeller] = useState(null);
    const [buyer, setBuyer] = useState(null);
    let errors = [];

    useEffect(() => {
        dispatch(invoicesActions.getOne(id));
        dispatch(companiesActions.getAll());
    }, []);
    
    const handleSubmit = (event) => {
        event.preventDefault();

        dispatch(invoicesActions.updateInvoice(invoice));
    }

    const handleSelectChange = (value, meta) => {
        invoice[meta.name] = value.id;

        dispatch(invoicesActions.change(invoice));
    }

    const handleVatPercentageChange = (value, meta) => {
        invoice[meta.name] = value.value;

        dispatch(invoicesActions.change(invoice));
    }

    const handleChange = (element) => {
        const {name, value} = element.target;
        invoice[name] = value;

        dispatch(invoicesActions.change(invoice));
    }

    const onProductsDragEnd = result => {
        const {destination, source} = result;

        if (!destination) {
            return;
        }

        if (destination.index === source.index) {
            return;
        }

        const products = Array.from(invoice.products);
        const product = products[source.index];
        products.splice(source.index, 1);
        products.splice(destination.index, 0, product);

        invoice.products = products;
        dispatch(invoicesActions.change(invoice));
    }

    function setLastDayPreviousMonth(property) {
        const today = new Date;
        invoice[property] = _parseDate(new Date(today.getFullYear(), today.getMonth(), 0));
        dispatch(invoicesActions.change(invoice));
    }

    function addNewProduct() {
        const products = invoice.products;
        products.push({name: '', price: 0.00});

        invoice.products = products;
        dispatch(invoicesActions.change(invoice));
    }

    function handleProductsParametersChange(e, index) {
        let products = invoice.products;
        const { name, value } = e.target;

        products[index] = { ...products[index], [name]: value};
        invoice.products = products;

        dispatch(invoicesActions.change(invoice));
    }

    function deleteProduct(index) {
        let products = invoice.products;
        products.splice(index, 1);

        invoice.products = products;

        dispatch(invoicesActions.change(invoice));
    }

    function _parseDate(date) {
        return ("0" + date.getDate()).slice(-2) + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear();
    }

    function handleSoldAtChange(dateObject, dateString) {
        invoice.soldAt = dateString;

        dispatch(invoicesActions.change(invoice));
    }

    function handleGeneratedAtChange(dateObject, dateString) {
        invoice.generatedAt = dateString;

        dispatch(invoicesActions.change(invoice));
    }

    const closeToast = () => {
        dispatch(invoicesActions.clearAlerts());
    }

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    useEffect(() => {
        if (invoice && companiesOptions) {
            setSeller(companiesOptions.find(item => item.id === invoice.sellerId));
            setBuyer(companiesOptions.find(item => item.id === invoice.buyerId));
        }
    }, [invoice, companiesOptions]);

    const companiesOptions = companies.map((company) => ({value: company.id, label: company.name}));
    const contractorsOptions = () => new Promise(resolve => {
        resolve(
            contractorsService.getAll().then(data => {
                return data.map((contractor) => {return {value: contractor.id, label: contractor.name}});
            })
        )
    });

    const bankAccounts = useSelector(state => state.invoices.bankAccounts.all.items);
    const bankAccountsOptions = bankAccounts.map((bankAccount) => ({value: bankAccount.id, label: bankAccount.name}));

    const customStyles = {
        control: (provided) => ({...provided, fontSize: '.8125rem', fontWeight: 400, lineHeight: 1.5, minHeight: '36px', height: 'calc(1.5em + .5rem + 2px)'}),
        option: (provided) => ({...provided, fontSize: '.8125rem', fontWeight: 400, lineHeight: 1.5, minHeight: '36px', height: 'calc(1.5em + .5rem + 2px)'})
    };

    return (invoice
        ?
            <div className="container-fluid">
                <div
                    style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                    <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Edit {invoice.invoiceNumber}</h4>
                    <div>
                        <nav>
                            <ol className="breadcrumb m-0">
                                <li className="breadcrumb-item">
                                    <Link to={'/invoices/documents'}
                                          style={{textDecoration: 'none', color: '#495057'}}>Documents</Link>
                                </li>
                                <li className="active breadcrumb-item">
                                    <Link to={'/invoices/documents/edit/' + invoice.id}
                                          style={{textDecoration: 'none', color: '#74788d'}}>Edit Invoice <b>{invoice.invoiceNumber}</b></Link>
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
                                    Invoice Information
                                </div>
                                <form onSubmit={handleSubmit}>
                                    <div className="row">
                                        <div className="col-sm-6">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="invoiceNumber" style={{marginBottom: '.5rem', fontWeight: 500}}>
                                                    Invoice number
                                                </label>
                                                <input name="invoiceNumber" placeholder="Enter invoice number..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       value={invoice.invoiceNumber}
                                                />
                                                {errors['invoiceNumber'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['invoiceNumber'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="companyId"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Company</label>
                                                <Select
                                                    name="companyId"
                                                    options={companiesOptions}
                                                    value={companiesOptions[0]}
                                                    isDisabled={companiesOptions.length === 1}
                                                />
                                                {errors['companyId'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['companyId'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="contractorId"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Contractor</label>
                                                <AsyncSelect
                                                    name="contractorId"
                                                    loadOptions={contractorsOptions}
                                                    defaultOptions
                                                    placeholder={'Choose contractor'}
                                                    style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                    onChange={handleSelectChange}
                                                />
                                                {errors['contractorId'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['contractorId'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="generatedAt"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Generate Date</label>
                                                <div className="input-group mb-3">
                                                    <Flatpickr
                                                        name="generatedAt"
                                                        placeholder="Choose generate invoice date"
                                                        value={invoice.generatedAt}
                                                        options={{dateFormat: 'd-m-Y'}}
                                                        onChange={date => (console.log(date))}
                                                        className="form-control"
                                                        style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, backgroundColor: '#fff'}}
                                                    />
                                                    <button className="btn btn-outline-secondary"
                                                            type="button"
                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, zIndex: 0}}
                                                            onClick={() => setLastDayPreviousMonth('generatedAt')}
                                                    >
                                                        Last Day Previous Month
                                                    </button>
                                                    <button className="btn btn-outline-secondary"
                                                            type="button"
                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, zIndex: 0}}
                                                            onClick={() => setLastDayCurrentMonth('generatedAt')}
                                                    >
                                                        Last Day Current Month
                                                    </button>
                                                </div>
                                                {errors['generatedAt'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['generatedAt'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="soldAt"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Sell Date</label>
                                                <div className="input-group mb-3">
                                                    <Flatpickr
                                                        name="soldAt"
                                                        placeholder="Choose sell invoice date"
                                                        value={invoice.soldAt}
                                                        options={{dateFormat: 'd-m-Y'}}
                                                        onChange={date => (console.log('testing'))}
                                                        className="form-control"
                                                        style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, backgroundColor: '#fff'}}
                                                    />
                                                    <button className="btn btn-outline-secondary"
                                                            type="button"
                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, zIndex: 0}}
                                                            onClick={() => setLastDayPreviousMonth('soldAt')}
                                                    >
                                                        Last Day Previous Month
                                                    </button>
                                                    <button className="btn btn-outline-secondary"
                                                            type="button"
                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, zIndex: 0}}
                                                            onClick={() => setLastDayCurrentMonth('soldAt')}
                                                    >
                                                        Last Day Current Month
                                                    </button>
                                                </div>
                                                {errors['soldAt'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['soldAt'].message}</span>
                                                }
                                            </div>
                                        </div>

                                        <div className="col-sm-6">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="generatePlace"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Generate Place</label>
                                                <input name="generatePlace"
                                                       placeholder="Enter invoice generate place (eg. Warsaw)" type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                />
                                                {errors['generatePlace'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['generatePlace'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="alreadyTakenPrice"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Already Taken Price</label>
                                                <input name="alreadyTakenPrice" placeholder="Enter already taken price..."
                                                       type="number" className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       step='0.01'
                                                       value={invoice.alreadyTakenPrice}
                                                />
                                                {errors['alreadyTakenPrice'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['alreadyTakenPrice'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="daysForPayment"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Days For Payment</label>
                                                <input name="daysForPayment" placeholder="Enter days for payment"
                                                       type="number" className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       step='1'
                                                       value={invoice.daysForPayment}
                                                />
                                                {errors['daysForPayment'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['daysForPayment'].message}</span>
                                                }
                                            </div>
                                            {invoice.companyId &&
                                                <>
                                                    <div className="mb-3 form-group">
                                                        <label htmlFor="paymentType"
                                                               style={{marginBottom: '.5rem', fontWeight: 500}}>Payment Type</label>
                                                        <Select
                                                            options={[
                                                                {value: 'bank_transfer', label: 'Bank transfer'}
                                                            ]}
                                                            defaultValue={{value: 'bank_transfer', label: 'Bank transfer'}}
                                                            isDisabled={true}
                                                        />
                                                        {errors['paymentType'] &&
                                                            <span style={{color: 'red', fontSize: '10px'}}>{errors['paymentType'].message}</span>
                                                        }
                                                    </div>
                                                    {invoice.paymentType === 'bank_transfer' &&
                                                        <div className="mb-3 form-group">
                                                            <label htmlFor="bankAccountId"
                                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Bank Account</label>
                                                            <Select
                                                                options={bankAccountsOptions}
                                                                value={bankAccountsOptions[0]}
                                                                isDisabled={bankAccountsOptions.length === 1}
                                                                name="bankAccountId"
                                                            />
                                                            {errors['bankAccountId'] &&
                                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['bankAccountId'].message}</span>
                                                            }
                                                        </div>
                                                    }
                                                </>
                                            }
                                            <div className="mb-3 form-group">
                                                <label htmlFor="language"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Language</label>
                                                <Select
                                                    options={[
                                                        {value: 'pl', label: 'Poland'}
                                                    ]}
                                                    defaultValue={{value: 'pl', label: 'Poland'}}
                                                    isDisabled={true}
                                                />
                                                {errors['language'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['language'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="currencyCode"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Currency Code</label>
                                                <Select
                                                    options={[
                                                        {value: 'pln', label: 'PLN'}
                                                    ]}
                                                    defaultValue={{value: 'pln', label: 'PLN'}}
                                                    isDisabled={true}
                                                />
                                                {errors['currencyCode'] &&
                                                    <span style={{color: 'red', fontSize: '10px'}}>{errors['currencyCode'].message}</span>
                                                }
                                            </div>
                                        </div>
                                    </div>

                                    <label className="col-form-label col-lg-2">
                                        Add Products
                                    </label>
                                    {errors['products'] &&
                                        <span style={{color: 'red', fontSize: '10px'}}>Minimum one added product is required.</span>
                                    }

                                    <div className="inner form-group mb-0 row">
                                        <div className="inner">
                                            <div className="row">
                                                <div className="col-4" style={{textAlign: 'center'}}>Product name</div>
                                                <div className="col-1" style={{textAlign: 'center'}}>Unit</div>
                                                <div className="col-1" style={{textAlign: 'center'}}>Quantity</div>
                                                <div className="col-2" style={{textAlign: 'center'}}>Price netto</div>
                                                <div className="col-1" style={{textAlign: 'center'}}>Rate</div>
                                                <div className="col-2" style={{textAlign: 'center'}}>Price gross</div>
                                            </div>

                                            <DragDropContext
                                                onDragEnd={onProductsDragEnd}
                                            >
                                                <Droppable droppableId="products">
                                                    {provided => (
                                                        <div {...provided.droppableProps} ref={provided.innerRef}>
                                                            {invoice.products.map((element, key) => {
                                                                return (
                                                                    <Draggable draggableId={key.toString()} index={key} key={key}>
                                                                        {provided => (
                                                                            <div
                                                                                {...provided.draggableProps}
                                                                                {...provided.dragHandleProps}
                                                                                ref={provided.innerRef}
                                                                            >
                                                                                <div className="row gx-1 align-items-center" style={{padding: '4px', marginBottom: '2px', fontSize: '8px'}}>
                                                                                    <div className="col-4" style={{display: 'flex', justifyContent: 'center', alignItems: 'center'}}>
                                                                                        <div>
                                                                                            <i className="bi bi-grip-vertical"
                                                                                               style={{
                                                                                                   minWidth: '1.5rem',
                                                                                                   paddingBottom: '.125em',
                                                                                                   fontSize: '1.25rem',
                                                                                                   lineHeight: '1.40625rem',
                                                                                                   verticalAlign: 'middle',
                                                                                                   transition: 'all .4s'
                                                                                               }}
                                                                                            />
                                                                                        </div>

                                                                                        <div style={{height: '100%', width: '100%'}}>
                                                                                        <textarea
                                                                                            rows="1"
                                                                                            name="name"
                                                                                            className="form-control"
                                                                                            placeholder="Invoice product name"
                                                                                            style={{
                                                                                                padding: '.47rem .75rem',
                                                                                                fontSize: '.8125rem',
                                                                                                fontWeight: 400,
                                                                                                lineHeight: 1.5,
                                                                                                resize: 'none',
                                                                                            }}
                                                                                            value={element.name}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div className="col-1">
                                                                                        <input
                                                                                            name="unit"
                                                                                            type="text"
                                                                                            className="form-control"
                                                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                            value={element.unit}
                                                                                            disabled={true}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                    </div>
                                                                                    <div className="col-1">
                                                                                        <input
                                                                                            name="quantity"
                                                                                            type="number"
                                                                                            step="1"
                                                                                            className="form-control"
                                                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                            value={element.quantity}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                    </div>
                                                                                    <div className="col-2">
                                                                                        <input
                                                                                            name="netPrice"
                                                                                            type="number"
                                                                                            step="0.01"
                                                                                            className="form-control"
                                                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                            value={element.netPrice}
                                                                                            onBlur={(e) => setFixedFloatPrice(e, key)}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                    </div>
                                                                                    <div className="col-1">
                                                                                        <Select
                                                                                            options={[
                                                                                                {value: -1, label: 'n/a'},
                                                                                                {value: 0, label: '0%'},
                                                                                                {value: 23, label: '23%'},
                                                                                            ]}
                                                                                            styles={customStyles}
                                                                                            name="tax"
                                                                                            placeholder="Select VAT percentage"
                                                                                            defaultValue={{value: 23, label: '23%'}}
                                                                                            onChange={handleSelectChange}
                                                                                        />
                                                                                    </div>
                                                                                    <div className="col-2">
                                                                                        <input
                                                                                            name="grossPrice"
                                                                                            type="number"
                                                                                            step="0.01"
                                                                                            className="form-control"
                                                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                            value={element.grossPrice}
                                                                                            onBlur={(e) => setFixedFloatPrice(e, key)}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                    </div>
                                                                                    <div className="col-1">
                                                                                        <button type="button"
                                                                                                className="btn btn-danger"
                                                                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, width: '100%'}}
                                                                                                onClick={() => deleteProduct(key)}
                                                                                        >
                                                                                            X
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        )}
                                                                    </Draggable>
                                                                )
                                                            })}
                                                            {provided.placeholder}
                                                        </div>
                                                    )}
                                                </Droppable>
                                            </DragDropContext>
                                            <div className="row mt-2">
                                                <div className="col-lg-10">
                                                    <button
                                                        type="button"
                                                        className="inner btn btn-success"
                                                        style={{fontSize: '1rem', display: 'block', fontWeight: 2000, lineHeight: 1.5, padding: '.1rem .5rem'}}
                                                        onClick={addNewProduct}
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="justify-content-end row mt-5">
                                        <div className="col-lg-12">
                                            {isLoading
                                                ? (
                                                    <button type="submit" className="btn btn-primary" style={{fontSize: '13px'}}>
                                                        <i className="bi bi-arrow-clockwise icon-spin" style={{marginRight: '10px', display: 'inline-block'}}/>
                                                        Loading...
                                                    </button>
                                                )
                                                : <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} value="Save Changes"/>
                                            }
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};