import React, {useEffect, useState} from 'react';
import {Link, useParams} from 'react-router-dom';
import {invoicesActions} from "../../../actions/invoices.actions";
import {useDispatch, useSelector} from "react-redux";
import {Toast} from "react-bootstrap";
import AsyncSelect from "react-select/async/dist/react-select.esm";
import Flatpickr from "react-flatpickr";
import Select from "react-select";
import {DragDropContext, Draggable, Droppable} from "react-beautiful-dnd";
import {contractorsService} from "../../../services/invoices/contractors/crud.service";
import './Invoices.css';
import 'boxicons/css/boxicons.min.css';
import {contractorsActions} from "../../../actions/invoices/contractors/actions";

function Edit() {
    const {id} = useParams();
    const dispatch = useDispatch();
    const invoice = useSelector(state => state.invoices.one.invoice);
    const isLoading = useSelector(state => state.invoices.update.isLoading);
    const isUpdated = useSelector(state => state.invoices.update.isUpdated);
    const validationErrors = useSelector(state => state.invoices.update.validationErrors);
    const companiesOptions = useSelector(state => state.companies.items);
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

    return (invoice
        ?
            <div className="container-fluid">
                <div
                    style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                    <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>
                        Edit Invoice Nr. {invoice.invoiceNumber}
                    </h4>
                    <div>
                        <nav>
                            <ol className="breadcrumb m-0">
                                <li className="breadcrumb-item">
                                    <Link to="/invoices/documents"
                                       style={{textDecoration: 'none', color: '#495057'}}>Invoices</Link>
                                </li>
                                <li className="active breadcrumb-item">
                                    <Link to={'/invoices/documents/edit/' + invoice.id}
                                       style={{textDecoration: 'none', color: '#74788d'}}>Edit Invoice</Link>
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
                                                       defaultValue={invoice.invoiceNumber}
                                                       onChange={handleChange}
                                                />
                                                {errors['invoiceNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['invoiceNumber'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="sellerId"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}
                                                >
                                                    Seller
                                                </label>
                                                <Select
                                                    name="sellerId"
                                                    options={companiesOptions}
                                                    defaultOptions
                                                    value={seller}
                                                    getOptionLabel={option => option.name}
                                                    getOptionValue={option => option.id}
                                                    placeholder={'Choose seller'}
                                                    style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                    onChange={handleSelectChange}
                                                />
                                                {errors['sellerId'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['sellerId'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="buyerId"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Buyer</label>
                                                <Select
                                                    name="buyerId"
                                                    options={companiesOptions}
                                                    defaultOptions
                                                    value={buyer}
                                                    getOptionLabel={option => option.name}
                                                    getOptionValue={option => option.id}
                                                    placeholder={'Choose buyer'}
                                                    style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                    onChange={handleSelectChange}
                                                />
                                                {errors['buyerId'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['buyerId'].message}</span>
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
                                                        onChange={handleGeneratedAtChange}
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
                                                        onChange={handleSoldAtChange}
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
                                                       defaultValue={invoice.generatePlace}
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
                                                       type="number"
                                                       className="form-control"
                                                       defaultValue={invoice.alreadyTakenPrice}
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       step='0.01'
                                                />
                                                {errors['alreadyTakenPrice'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['alreadyTakenPrice'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="language"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Language</label>
                                                <Select
                                                    options={[
                                                        {value: 'pl', label: 'Poland'}
                                                    ]}
                                                    placeholder="Select language"
                                                    defaultValue={{value: 'pl', label: 'Poland'}}
                                                />
                                                {errors['language'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['language'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="currencyCode"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Currency Code</label>
                                                <input name="currencyCode"
                                                       placeholder="Enter currency code..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       value={invoice.currencyCode}
                                                       readOnly
                                                />
                                                {errors['currencyCode'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['currencyCode'].message}</span>
                                                }
                                            </div>
                                            <div className="mb-3 form-group">
                                                <label htmlFor="vatPercentage"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>VAT Percentage</label>
                                                <Select
                                                    options={[
                                                        {value: 0, label: '0%'},
                                                        {value: 23, label: '23%'},
                                                    ]}
                                                    placeholder="Select language"
                                                    defaultValue={{value: invoice.vatPercentage, label: invoice.vatPercentage + '%'}}
                                                    onChange={handleVatPercentageChange}
                                                    name="vatPercentage"
                                                />
                                                {errors['vatPercentage'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['vatPercentage'].message}</span>
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
                                                                                <div className="row align-items-center" style={{padding: '3px', marginBottom: '2px'}}>
                                                                                    <div className="col-9">
                                                                                        <div style={{display: 'inline-block', width: '3%'}}>
                                                                                            <i className="bi bi-grip-vertical col-1"
                                                                                               style={{
                                                                                                   minWidth: '1.5rem',
                                                                                                   display: 'inline-block',
                                                                                                   paddingBottom: '.125em',
                                                                                                   fontSize: '1.25rem',
                                                                                                   lineHeight: '1.40625rem',
                                                                                                   verticalAlign: 'middle',
                                                                                                   transition: 'all .4s'
                                                                                               }}
                                                                                            />
                                                                                        </div>
                                                                                        <div style={{display: 'inline-block', width: '97%'}}>
                                                                                            <input
                                                                                                name="name"
                                                                                                type="text"
                                                                                                className="form-control"
                                                                                                placeholder="Invoice product name"
                                                                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                                value={element.name}
                                                                                                onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                            />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div className="col-2">
                                                                                        <input
                                                                                            name="price"
                                                                                            type="number"
                                                                                            step="0.01"
                                                                                            className="form-control"
                                                                                            placeholder="Invoice product price"
                                                                                            style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                            value={element.price}
                                                                                            onChange={(e) => handleProductsParametersChange(e, key)}
                                                                                        />
                                                                                    </div>

                                                                                    <div className="col-1">
                                                                                        <button type="button"
                                                                                                className="btn btn-danger"
                                                                                                style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5, width: '100%', color: '#fff'}}
                                                                                                onClick={() => deleteProduct(key)}
                                                                                        >
                                                                                            Remove
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
                                                        style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                        onClick={addNewProduct}
                                                    >
                                                        Add Product
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

                <div style={{position: 'absolute', bottom: 80, right: 20}}>
                    <Toast style={{backgroundColor: '#00ca72'}}
                           show={!!isUpdated}
                           onClose={closeToast}
                           delay={3000}
                           autohide
                    >
                        <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                            <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                        </Toast.Header>
                        <Toast.Body style={{color: '#fff'}}>
                            Invoice information was successfully updated and invoice was regenerated.
                        </Toast.Body>
                    </Toast>
                </div>

            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};