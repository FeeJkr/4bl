const fields = {
    name: 'name',
    identificationNumber: 'identificationNumber',
    email: 'email',
    phoneNumber: 'phoneNumber',
    isVatPayer: 'isVatPayer',
    vatRejectionReason: 'vatRejectionReason',
    address: 'address',
    street: 'street',
    city: 'city',
    zipCode: 'zipCode',
};

const placeholders = {
    [fields.name]: 'Enter company name...',
    [fields.identificationNumber]: 'Enter identification number...',
    [fields.email]: 'Enter email address...',
    [fields.phoneNumber]: 'Enter phone number...',
    [fields.street]: 'Enter company location street...',
    [fields.city]: 'Enter company location city...',
    [fields.zipCode]: 'Enter company location zip code...',
};

const labels = {
    [fields.name]: 'Company name',
    [fields.identificationNumber]: 'Identification number',
    [fields.email]: 'Email',
    [fields.phoneNumber]: 'Phone number',
    [fields.isVatPayer]: 'Is Company VAT Payer?',
    [fields.vatRejectionReason]: 'VAT Rejection Reason',
    [fields.street]: 'Street',
    [fields.city]: 'City',
    [fields.zipCode]: 'Zip code',
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
        company.address[fields[name]] = value === '' ? null : value;

        return;
    }

    company[fields[name]] = value === '' ? null : value;

    return company;
};

export {fields, placeholders, labels, handleChanges};