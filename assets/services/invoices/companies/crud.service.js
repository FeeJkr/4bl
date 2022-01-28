import axios from "axios";
import {companiesDictionary as dictionary} from "../../../helpers/routes/invoices/companies/dictionary";

export const companiesService = {
    getAll,
    getOneById,
    createCompany,
    updateCompany,
    deleteCompany,
};

function getAll() {
    return axios
        .get(dictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function getOneById(id) {
    return axios
        .get(dictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}

function createCompany(formData) {
    return axios.post(dictionary.CREATE_URL, {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        addressId: data.id,
    }).catch(error => Promise.reject(error.response.data));
}

function updateCompany(id, formData) {
    return axios.post(dictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}

function deleteCompany(id) {
    return axios.delete(dictionary.DELETE_URL.replace('{id}', id));
}
