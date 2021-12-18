import "flatpickr/dist/themes/airbnb.css";

import React, {useState} from 'react';
import {Link, useNavigate} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {invoicesActions} from "../../../actions/invoices.actions";
import AsyncSelect from 'react-select/async';
import {companiesService} from "../../../services/companies.service";
import Flatpickr from "react-flatpickr";
import {DragDropContext, Draggable, Droppable} from "react-beautiful-dnd";
import Select from "react-select";

function Generate() {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const validationErrors = useSelector(state => state.invoices.create.validationErrors);
    const isLoading = useSelector(state => state.invoices.create.isLoading);
    let errors = [];
    const [inputs, setInputs] = useState({
        invoiceNumber: '',
        sellerId: '',
        buyerId: '',
        generatedAt: new Date,
        soldAt: new Date,
        generatePlace: '',
        alreadyTakenPrice: 0.00,
        currencyCode: 'PLN',
        vatPercentage: 23,
        products: [
            {name: '', unit: 'test', quantity: 1, priceNetto: 0.00, vatRate: 23, priceGross: 0.00},
        ],
    });

    function handleChange(e) {
        const { name, value } = e.target;
        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    function handleSelectChange(value, meta) {
        setInputs(inputs => ({ ...inputs, [meta.name]: value.value}));
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(invoicesActions.generateInvoice(inputs, navigate));
    }

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    const companiesOptions = () => new Promise(resolve => {
        resolve(
            companiesService.getAll().then(data => {
                return data.map((company) => {return {value: company.id, label: company.name}});
            })
        );
    });

    function setLastDayPreviousMonth(property) {
        const today = new Date;
        setInputs(inputs => ({ ...inputs, [property]: new Date(today.getFullYear(), today.getMonth(), 0)}));
    }

    function setLastDayCurrentMonth(property) {
        const today = new Date;
        setInputs(inputs => ({ ...inputs, [property]: new Date(today.getFullYear(), today.getMonth() + 1, 0)}));
    }

    function addNewProduct() {
        const products = inputs.products;
        products.push({name: '', unit: 'test', quantity: 1, priceNetto: 0.00, vatRate: 23, priceGross: 0.00});

        setInputs(inputs => ({...inputs, products}));
    }

    function handleProductsParametersChange(e, index) {
        let products = inputs.products;
        let { name, value } = e.target;

        if (name === 'name') {
            e.target.style.height = 'inherit';
            e.target.style.height = `${e.target.scrollHeight}px`;
            e.target.style.height = `${Math.min(e.target.scrollHeight, 54)}px`
        }

        if (name === 'priceGross') {
            if (products[index].vatRate === 0) {
                products[index] = {...products[index], priceNetto: value.toFixed(2)};
            } else {
                products[index] = {...products[index], priceNetto: (parseFloat(value) / (1 + (products[index].vatRate / 100))).toFixed(2)};
            }
        }

        if (name === 'priceNetto') {
            if (products[index].vatRate === 0) {
                products[index] = {...products[index], priceGross: value.toFixed(2)};
            } else {
                products[index] = {...products[index], priceGross: (parseFloat(value) + (parseFloat(value) * (products[index].vatRate / 100))).toFixed(2)};
            }
        }

        if (name === 'vatRate') {
            if (value === 0) {
                products[index] = {...products[index], priceGross: (products[index].priceNetto).toFixed(2)};
            } else {
                products[index] = {...products[index], priceGross: (parseFloat(products[index].priceNetto) + (parseFloat(products[index].priceNetto) * (value / 100))).toFixed(2)};
            }
        }

        products[index] = { ...products[index], [name]: value};
        setInputs(inputs => ({ ...inputs, products }));
    }

    function deleteProduct(index) {
        let products = inputs.products;
        products.splice(index, 1);

        setInputs(inputs => ({ ...inputs, products }));
    }

    const onProductsDragEnd = result => {
        const {destination, source} = result;

        if (!destination) {
            return;
        }

        if (destination.index === source.index) {
            return;
        }

        const products = Array.from(inputs.products);
        const product = products[source.index];
        products.splice(source.index, 1);
        products.splice(destination.index, 0, product);

        setInputs(inputs => ({ ...inputs, products }));
    }

    const setFixedFloatPrice = (e, index) => {
        let products = inputs.products;
        let { name, value } = e.target;

        products[index] = { ...products[index], [name]: parseFloat(value).toFixed(2)};
        setInputs(inputs => ({ ...inputs, products }));
    }

    const customStyles = {
        control: (provided) => ({...provided, fontSize: '.8125rem', fontWeight: 400, lineHeight: 1.5, minHeight: '36px', height: 'calc(1.5em + .5rem + 2px)'}),
        option: (provided) => ({...provided, fontSize: '.8125rem', fontWeight: 400, lineHeight: 1.5, minHeight: '36px', height: 'calc(1.5em + .5rem + 2px)'})
    };

    return (
        <div className="container-fluid">
            <div
                style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Generate new</h4>
                <div>
                    <nav>
                        <ol className="breadcrumb m-0">
                            <li className="breadcrumb-item">
                                <Link to={'/invoices/documents'}
                                   style={{textDecoration: 'none', color: '#495057'}}>Documents</Link>
                            </li>
                            <li className="active breadcrumb-item">
                                <Link to={'/invoices/documents/new'}
                                   style={{textDecoration: 'none', color: '#74788d'}}>Generate Invoice</Link>
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
                                            />
                                            {errors['invoiceNumber'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['invoiceNumber'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="buyerId"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Buyer</label>
                                            <AsyncSelect
                                                name="buyerId"
                                                loadOptions={companiesOptions}
                                                defaultOptions
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
                                                    value={inputs.generatedAt}
                                                    options={{dateFormat: 'd-m-Y'}}
                                                    onChange={date => (setInputs(inputs => ({ ...inputs, generatedAt: date[0]})))}
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
                                                    value={inputs.soldAt}
                                                    options={{dateFormat: 'd-m-Y'}}
                                                    onChange={date => (setInputs(inputs => ({ ...inputs, soldAt: date[0]})))}
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
                                                   value={inputs.alreadyTakenPrice}
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
                                                   value={inputs.daysForPayment}
                                            />
                                            {errors['daysForPayment'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['daysForPayment'].message}</span>
                                            }
                                        </div>
                                        <div className="mb-3 form-group">
                                            <label htmlFor="paymentType"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Payment Type</label>
                                            <Select
                                                options={[
                                                    {value: 'bankTransfer', label: 'Bank transfer'}
                                                ]}
                                                defaultValue={{value: 'bankTransfer', label: 'Bank transfer'}}
                                                isDisabled={true}
                                            />
                                            {errors['paymentType'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['paymentType'].message}</span>
                                            }
                                        </div>
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
                                                        {inputs.products.map((element, key) => {
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
                                                                                        name="priceNetto"
                                                                                        type="number"
                                                                                        step="0.01"
                                                                                        className="form-control"
                                                                                        style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                        value={element.priceNetto}
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
                                                                                        name="vatPercentage"
                                                                                        placeholder="Select VAT percentage"
                                                                                        defaultValue={{value: 23, label: '23%'}}
                                                                                        onChange={handleSelectChange}
                                                                                    />
                                                                                </div>
                                                                                <div className="col-2">
                                                                                    <input
                                                                                        name="priceGross"
                                                                                        type="number"
                                                                                        step="0.01"
                                                                                        className="form-control"
                                                                                        style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                                                        value={element.priceGross}
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
    );
}

export {Generate};