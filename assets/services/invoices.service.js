import axios from "axios";
import {invoicesDictionary} from "../helpers/routes/invoices.dictionary";

export const invoicesService = {
    getAll,
    generateInvoice,
    deleteInvoice,
    getOne,
    updateInvoice,
};

function getAll() {
    return axios.get(invoicesDictionary.GET_ALL_URL).then((response) => response.data);
}

function generateInvoice(formData) {
    const products = formData.products.map((element, index) => {
        return {...element, position: index};
    });

    return axios.post(invoicesDictionary.CREATE_URL, {
        invoiceNumber: formData.invoiceNumber,
        sellerId: formData.sellerId,
        buyerId: formData.buyerId,
        generatePlace: formData.generatePlace,
        alreadyTakenPrice: formData.alreadyTakenPrice,
        generateDate: _parseDate(formData.generatedAt),
        sellDate: _parseDate(formData.soldAt),
        currencyCode: formData.currencyCode,
        products: products.filter((element) => element.name !== ''),
    }).catch(error => Promise.reject(error.response.data));
}

function _parseDate(date) {
    return ("0" + date.getDate()).slice(-2) + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + date.getFullYear();
}

function deleteInvoice(id) {
    return axios.delete(invoicesDictionary.DELETE_URL.replace('{id}', id));
}

function getOne(id) {
    return axios.get(invoicesDictionary.GET_ONE_URL.replace('{id}', id)).then((response) => response.data);
}

function updateInvoice(invoice) {

    const products = invoice.products.map((element, index) => {
        return {...element, position: index};
    });

    return axios.post(invoicesDictionary.UPDATE_URL.replace('{id}', invoice.id), {
        invoiceNumber: invoice.invoiceNumber,
        sellerId: invoice.sellerId,
        buyerId: invoice.buyerId,
        generatePlace: invoice.generatePlace,
        alreadyTakenPrice: invoice.alreadyTakenPrice,
        generateDate: invoice.generatedAt,
        sellDate: invoice.soldAt,
        currencyCode: invoice.currencyCode,
        products: products.filter((element) => element.name !== ''),
    }).catch(error => Promise.reject(error.response.data));
}