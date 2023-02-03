import Select from "react-select";
import AsyncSelect from "react-select/async";
import Flatpickr from "react-flatpickr";
import {DragDropContext, Draggable, Droppable} from "react-beautiful-dnd";
import {Fragment} from "react";

const GenerateForm = () => {
    return (
        <Fragment>
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
                        {inputs.companyId &&
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
                                {inputs.paymentType === 'bank_transfer' &&
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
        </Fragment>
    );
}

export default GenerateForm;