import {companiesConstants} from "../constants/companies.constants";
import {companiesService} from "../services/companies.service";
import {history} from "../helpers/history";

export const companiesActions = {
    getAll,
    deleteCompany,
    createCompany,
    getOne,
    updateCompanyBasicInformation,
    updateCompanyPaymentInformation,
    clearAlerts,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        companiesService.getAll()
            .then(
                companies => dispatch(success(companies)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: companiesConstants.GET_ALL_REQUEST } }
    function success(companies) { return { type: companiesConstants.GET_ALL_SUCCESS, companies } }
    function failure(errors) { return { type: companiesConstants.GET_ALL_FAILURE, errors } }
}

function deleteCompany(id) {
    return dispatch => {
        dispatch(request(id));

        companiesService.deleteCompany(id)
            .then(
                response => dispatch(success(id)),
                errors => dispatch(failure(id, errors))
            );
    };

    function request(id) { return { type: companiesConstants.DELETE_REQUEST, id } }
    function success(id) { return { type: companiesConstants.DELETE_SUCCESS, id } }
    function failure(id, error) { return { type: companiesConstants.DELETE_FAILURE, id, error } }
}

function createCompany(formData, navigate) {
    return dispatch => {
        dispatch(request(formData));

        companiesService.createCompany(formData)
            .then(
                response => {
                    dispatch(success());
                    navigate('/invoices/companies');
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: companiesConstants.CREATE_REQUEST, request: formData } }
    function success() { return { type: companiesConstants.CREATE_SUCCESS } }
    function failure(errors, company) {
        if (errors.type === 'DomainError') {
            return { type: companiesConstants.CREATE_FAILURE, errors, company }
        }

        return { type: companiesConstants.CREATE_VALIDATION_FAILURE, errors: errors.errors, company, }
    }
}

function getOne(id) {
    return dispatch => {
        dispatch(request());

        companiesService.getOne(id)
            .then(
                company => dispatch(success(company)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: companiesConstants.GET_ONE_REQUEST } }
    function success(company) { return { type: companiesConstants.GET_ONE_SUCCESS, company: company } }
    function failure(errors) { return { type: companiesConstants.GET_ONE_FAILURE, errors } }
}

function updateCompanyBasicInformation(id, formData) {
    console.log(id, formData);
    return dispatch => {
        dispatch(request(formData));

        companiesService.updateBasicInformation(id, formData)
            .then(
                response => dispatch(success(formData)),
                errors => dispatch(failure(errors))
            );
    };

    function request(request) { return { type: companiesConstants.UPDATE_BASIC_INFORMATION_REQUEST, request } }
    function success(formData) { return { type: companiesConstants.UPDATE_BASIC_INFORMATION_SUCCESS, company: formData } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: companiesConstants.UPDATE_BASIC_INFORMATION_FAILURE, errors }
        }

        return { type: companiesConstants.UPDATE_BASIC_INFORMATION_VALIDATION_FAILURE, errors: errors.errors }
    }
}

function updateCompanyPaymentInformation(id, formData) {
    return dispatch => {
        dispatch(request(formData));

        companiesService.updatePaymentInformation(id, formData)
            .then(
                response => dispatch(success(formData)),
                errors => dispatch(failure(errors))
            );
    };

    function request(request) { return { type: companiesConstants.UPDATE_PAYMENT_INFORMATION_REQUEST, request } }
    function success(company) { return { type: companiesConstants.UPDATE_PAYMENT_INFORMATION_SUCCESS, company } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: companiesConstants.UPDATE_PAYMENT_INFORMATION_FAILURE, errors }
        }

        return { type: companiesConstants.UPDATE_PAYMENT_INFORMATION_VALIDATION_FAILURE, errors: errors.errors }
    }
}

function clearAlerts() {
    return dispatch => {
        dispatch({type: companiesConstants.CLEAR_ALERTS});
    }
}
