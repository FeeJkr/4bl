import {handleChanges as changeAddress, fields as addressFields, labels as addressLabels, placeholders as addressPlaceholders} from "./addresses";

const fields = {
    name: 'name',
    identificationNumber: 'identificationNumber',
    email: 'email',
    phoneNumber: 'phoneNumber',
    isVatPayer: 'isVatPayer',
    vatRejectionReason: 'vatRejectionReason',
    ...addressFields,
};

const placeholders = {
    [fields.name]: 'Enter company name...',
    [fields.identificationNumber]: 'Enter identification number...',
    [fields.email]: 'Enter email address...',
    [fields.phoneNumber]: 'Enter phone number...',
    ...addressPlaceholders,
};

const labels = {
    [fields.name]: 'Company name',
    [fields.identificationNumber]: 'Identification number',
    [fields.email]: 'Email',
    [fields.phoneNumber]: 'Phone number',
    [fields.isVatPayer]: 'Is Company VAT Payer?',
    [fields.vatRejectionReason]: 'VAT Rejection Reason',
    ...addressLabels,
};

const handleChanges = (event, company) => {
    const { name, value } = event.target;

    if (name === fields.isVatPayer) {
        company[fields[name]] = !company.isVatPayer;

        if (company.isVatPayer) {
            company.vatRejectionReason = null;
        }

        return;
    }

    if ([fields.street, fields.city, fields.zipCode].includes(name)) {
        changeAddress(event, company.address);

        return;
    }

    company[fields[name]] = value === '' ? null : value;

    return company;
};

export {fields, placeholders, labels, handleChanges};