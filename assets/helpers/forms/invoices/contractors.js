import {handleChanges as changeAddress, fields as addressFields, labels as addressLabels, placeholders as addressPlaceholders} from "./addresses";

const fields = {
    name: 'name',
    identificationNumber: 'identificationNumber',
    ...addressFields,
};

const placeholders = {
    [fields.name]: 'Enter contractor name...',
    [fields.identificationNumber]: 'Enter identification number...',
    ...addressPlaceholders,
};

const labels = {
    [fields.name]: 'Contractor name',
    [fields.identificationNumber]: 'Identification number',
    ...addressLabels,
};

const handleChanges = (event, contractor) => {
    const { name, value } = event.target;

    if ([fields.street, fields.city, fields.zipCode].includes(name)) {
        changeAddress(event, contractor.address);

        return;
    }

    contractor[fields[name]] = value === '' ? null : value;
};

export {fields, placeholders, labels, handleChanges};