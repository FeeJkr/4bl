import axios from "axios";
import {companiesDictionary} from "../helpers/routes/companies.dictionary";

export const companiesService = {
    getAll,
    deleteCompany,
    createCompany,
    getOne,
    updateBasicInformation,
    updatePaymentInformation,
};

function getAll() {
    return axios.get(companiesDictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function deleteCompany(id) {
    return axios.delete(companiesDictionary.DELETE_URL.replace('{id}', id));
}

function createCompany(formData) {
    console.log(formData);

    return axios.post(companiesDictionary.CREATE_URL, {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}

function getOne(id) {
    return axios.get(companiesDictionary.GET_ONE_URL.replace('{id}', id)).then((response) => response.data);
}

function updateBasicInformation(id, formData) {
    return axios.post(companiesDictionary.UPDATE_BASIC_INFORMATION_URL.replace('{id}', id), {
        name: formData.name,
        identificationNumber: formData.identificationNumber,
        email: formData.email,
        phoneNumber: formData.phoneNumber,
        street: formData.street,
        zipCode: formData.zipCode,
        city: formData.city,
    }).catch(error => Promise.reject(error.response.data));
}

function updatePaymentInformation(id, formData) {
    return axios.post(companiesDictionary.UPDATE_PAYMENT_INFORMATION_URL.replace('{id}', id), {
        paymentType: formData.paymentType,
        paymentLastDate: formData.paymentLastDate,
        bank: formData.bank,
        accountNumber: formData.accountNumber,
    }).catch(error => Promise.reject(error.response.data));
}
