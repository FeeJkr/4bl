import axios from "axios";
import {documentsDictionary as dictionary} from "../../../helpers/routes/invoices/documents/dictionary";

export const documentsService = {
    getAll,
    getOneById,
    createDocument,
    updateDocument,
    deleteDocument,
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

function createDocument(formData) {
    return axios.post(dictionary.CREATE_URL, {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        addressId: data.id,
    }).catch(error => Promise.reject(error.response.data));
}

function updateDocument(id, formData) {
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

function deleteDocument(id) {
    return axios.delete(dictionary.DELETE_URL.replace('{id}', id));
}
