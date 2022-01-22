import axios from "axios";
import {contractorsDictionary} from "../../../helpers/routes/invoices/contractors/dictionary";

export const contractorsService = {
    getAll,
    getOneById,
    createContractor,
    updateContractor,
    deleteContractor,
};

function getAll() {
    return axios
        .get(contractorsDictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function getOneById(id) {
    return axios
        .get(contractorsDictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}

function createContractor(formData) {
    return axios.post(contractorsDictionary.CREATE_URL, {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}

function updateContractor(id, formData) {
    return axios.post(contractorsDictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}

function deleteContractor(id) {
    return axios.delete(contractorsDictionary.DELETE_URL.replace('{id}', id));
}
