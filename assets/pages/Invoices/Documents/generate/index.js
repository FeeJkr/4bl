import {useDispatch, useSelector} from "react-redux";
import {Link, useNavigate} from "react-router-dom";
import {contractorsService} from "../../../../services/invoices/contractors/crud.service";
import GenerateForm from "./GenerateForm";
import {useEffect, useState} from "react";

const GenerateDocument = () => {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [inputs, setInputs] = useState({
        invoiceNumber: '',
        generatePlace: '',
        alreadyTakenPrice: '',
        daysForPayment: '',
        paymentType: 'bank_transfer',
        bankAccountId: null,
        currencyCode: 'PLN',
        companyId: null,
        contractorId: null,
        generatedAt: null,
        soldAt: null,
        products: [
            {position: 0, name: '', unit: 'service', quantity: 1, netPrice: 0.00, tax: 23, grossPrice: 0.00},
        ],
    });

    useEffect(() => {
        dispatch(companiesActions.getAll());
    }, []);

    function handleChange(e) {
        const { name, value } = e.target;
        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    function handleSelectChange(value, meta) {
        if (meta.name === 'companyId') {
            dispatch(bankAccountsActions.getAll(value.value));
        }

        setInputs(inputs => ({ ...inputs, [meta.name]: value.value}));
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(invoicesActions.generateInvoice(inputs, navigate));
    }

    const bankAccountsOptions = bankAccounts.map((bankAccount) => ({value: bankAccount.id, label: bankAccount.name}));
    const companiesOptions = companies.map((company) => ({value: company.id, label: company.name}));
    const contractorsOptions = () => new Promise(resolve => {
        resolve(
            contractorsService.getAll().then(data => {
                return data.map((contractor) => {return {value: contractor.id, label: contractor.name}});
            })
        )
    });

    if (companiesOptions.length === 1 && inputs.companyId === null) {
        const companyId = companiesOptions[0].value;
        setInputs(inputs => ({...inputs , companyId}));
        dispatch(bankAccountsActions.getAll(companyId));
    }

    if (bankAccountsOptions.length === 1 && inputs.bankAccountId === null && inputs.paymentType === 'bank_transfer') {
        setInputs(inputs => ({...inputs, bankAccountId: bankAccountsOptions[0].value}));
    }

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
        products.push({name: '', unit: 'service', quantity: 1, netPrice: 0.00, tax: 23, grossPrice: 0.00});

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

        if (name === 'grossPrice') {
            if (products[index].tax === 0) {
                products[index] = {...products[index], netPrice: value.toFixed(2)};
            } else {
                products[index] = {...products[index], netPrice: (parseFloat(value) / (1 + (products[index].tax / 100))).toFixed(2)};
            }
        }

        if (name === 'netPrice') {
            if (products[index].tax === 0) {
                products[index] = {...products[index], grossPrice: value.toFixed(2)};
            } else {
                products[index] = {...products[index], grossPrice: (parseFloat(value) + (parseFloat(value) * (products[index].tax / 100))).toFixed(2)};
            }
        }

        if (name === 'tax') {
            if (value === 0) {
                products[index] = {...products[index], grossPrice: (products[index].netPrice).toFixed(2)};
            } else {
                products[index] = {...products[index], grossPrice: (parseFloat(products[index].netPrice) + (parseFloat(products[index].netPrice) * (value / 100))).toFixed(2)};
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
                            <GenerateForm/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default GenerateDocument;