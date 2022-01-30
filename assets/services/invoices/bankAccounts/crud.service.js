import axios from "axios";
import {bankAccountsDictionary as dictionary} from "../../../helpers/routes/invoices/bankAccounts/dictionary";

export const bankAccountsService = {
    getAll,
    getOneById,
    createBankAccount,
    updateBankAccount,
    deleteBankAccount,
};

function getAll(companyId) {
    return axios
        .get(dictionary.GET_ALL_URL.replace('{companyId}', companyId))
        .then((response) => response.data);
}

function getOneById(id) {
    return axios
        .get(dictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}

function createBankAccount(formData) {
    return axios.post(dictionary.CREATE_URL.replace('{companyId}', formData.companyId), {
        name: formData.name,
        companyId: formData.companyId,
        bankName: formData.bankName,
        bankAccountNumber: formData.bankAccountNumber,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function updateBankAccount(id, formData) {
    console.log(formData);

    return axios.post(dictionary.UPDATE_URL.replace('{id}', id).replace('{companyId}', formData.companyId), {
        name: formData.name,
        bankName: formData.bankName,
        bankAccountNumber: formData.bankAccountNumber,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function deleteBankAccount(id, companyId) {
    return axios.delete(dictionary.DELETE_URL.replace('{id}', id).replace('{companyId}', companyId));
}
