import axios from "axios";
import {periodsDictionary as dictionary} from "../../../helpers/routes/finances/budgets/periods.dictionary";

export const periodsService = {
    getAll,
    getOneById,
    createPeriod,
    updatePeriod,
    deletePeriod,
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

function createPeriod(formData) {
    return axios.post(dictionary.CREATE_URL, {
        name: formData.name,
        companyId: formData.companyId,
        bankName: formData.bankName,
        bankAccountNumber: formData.bankAccountNumber,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function updatePeriod(id, formData) {
    return axios.post(dictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        bankName: formData.bankName,
        bankAccountNumber: formData.bankAccountNumber,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function deletePeriod(id) {
    return axios.delete(dictionary.DELETE_URL.replace('{id}', id));
}
