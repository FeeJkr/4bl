const fields = {
    address: 'address',
    street: 'street',
    city: 'city',
    zipCode: 'zipCode',
};

const placeholders = {
    [fields.street]: 'Enter company location street...',
    [fields.city]: 'Enter company location city...',
    [fields.zipCode]: 'Enter company location zip code...',
};

const labels = {
    [fields.street]: 'Street',
    [fields.city]: 'City',
    [fields.zipCode]: 'Zip code',
};

const handleChanges = (event, address) => {
    const { name, value } = event.target;

    address[fields[name]] = value === '' ? null : value;
};

export {fields, placeholders, labels, handleChanges};
