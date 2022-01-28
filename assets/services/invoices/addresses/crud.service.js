import axios from "axios";
import {addressesDictionary} from "../../../helpers/routes/invoices/addresses/dictionary";
import {contractorsDictionary} from "../../../helpers/routes/invoices/contractors/dictionary";

export const addressesService = {
    getAll,
    getOneById,
    createAddress,
    updateAddress,
};

function getAll() {
    return axios
        .get(addressesDictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function getOneById(id) {
    return axios
        .get(addressesDictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}

function createAddress (formData) {
    return axios.post(addressesDictionary.CREATE_URL, {
        name: formData.name,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).then(
        response => response.data,
        error => Promise.reject(error.response.data)
    );
}

function updateAddress(id, formData) {
    return axios.post(addressesDictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}
