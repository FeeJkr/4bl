import axios from "axios";
import {invoicesDictionary} from "../helpers/routes/invoices.dictionary";

export const invoicesService = {
    getAll,
    generateInvoice,
    deleteInvoice,
    getOne,
    updateInvoice,
};

function getAll(filterDates) {
    let url = invoicesDictionary.GET_ALL_URL;

    if (filterDates.length === 2) {
        url += '?filter[generatedAt][0]=' + _parseDate(filterDates[0]) + '&filter[generatedAt][1]=' + _parseDate(filterDates[1]);
    }

    return axios.get(url).then((response) => response.data);
}

function generateInvoice(formData) {
    const products = formData.products.map((element, index) => {
        return {...element, position: index};
    });

    return axios.post(invoicesDictionary.CREATE_URL, {
        invoiceNumber: formData.invoiceNumber,
        generatePlace: formData.generatePlace,
        alreadyTakenPrice: formData.alreadyTakenPrice,
        daysForPayment: formData.daysForPayment,
        paymentType: formData.paymentType,
        bankAccountId: formData.bankAccountId,
        currencyCode: formData.currencyCode,
        companyId: formData.companyId,
        contractorId: formData.contractorId,
        generatedAt: _parseDate(formData.generatedAt),
        soldAt: _parseDate(formData.soldAt),
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
        vatPercentage: invoice.vatPercentage,
    }).catch(error => Promise.reject(error.response.data));
}