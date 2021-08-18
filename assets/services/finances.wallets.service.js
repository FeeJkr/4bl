import axios from "axios";
import {financesWalletsDictionary} from "../helpers/routes/finances.wallets.dictionary";

export const financesWalletsService = {
    createWallet,
    updateWallet,
    deleteWallet,
    getAll,
    getOne,
};

function createWallet(formData) {
    return axios.post(financesWalletsDictionary.CREATE_URL, {
        name: formData.name,
        startBalance: formData.startBalance,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function updateCategory(id, formData) {
    return axios.post(financesWalletsDictionary.UPDATE_URL.replace('{id}', id), {
        name: formData.name,
        startBalance: formData.startBalance,
        currency: formData.currency,
    }).catch(error => Promise.reject(error.response.data));
}

function deleteCategory(id) {
    return axios.delete(financesWalletsDictionary.DELETE_URL.replace('{id}', id));
}

function getAll() {
    return axios.get(financesWalletsDictionary.GET_ALL_URL)
        .then((response) => response.data);
}

function getOne(id) {
    return axios.get(financesWalletsDictionary.GET_ONE_URL.replace('{id}', id))
        .then((response) => response.data);
}
