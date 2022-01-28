import {companiesConstants as constants} from "../../../constants/invoices/companies/constants";
import {companiesService as service} from "../../../services/invoices/companies/crud.service";

export const companiesActions = {
    getAll,
    getOneById,
    createCompany,
    updateCompany,
    deleteCompany,
    clearAlerts,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        service.getAll()
            .then(
                items => dispatch(success(items)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: constants.GET_ALL_REQUEST } }
    function success(items) { return { type: constants.GET_ALL_SUCCESS, items: items } }
    function failure(errors) { return { type: constants.GET_ALL_FAILURE, errors } }
}

function getOneById(id) {
    return dispatch => {
        dispatch(request());

        service.getOneById(id)
            .then(
                item => dispatch(success(item)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: constants.GET_ONE_REQUEST } }
    function success(item) { return { type: constants.GET_ONE_SUCCESS, item: item } }
    function failure(errors) { return { type: constants.GET_ONE_FAILURE, errors } }
}

function createCompany(formData) {
    return dispatch => {
        dispatch(request(formData));

        service.createCompany(formData)
            .then(
                () => {
                    dispatch(success());
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: constants.CREATE_REQUEST, request: formData } }
    function success() { return { type: constants.CREATE_SUCCESS } }
    function failure(errors, company) {
        if (errors.type === 'DomainError') {
            return { type: constants.CREATE_FAILURE, errors, company }
        }

        return { type: constants.CREATE_VALIDATION_FAILURE, errors: errors.errors, company, }
    }
}

function updateCompany(id, formData) {
    return dispatch => {
        dispatch(request(formData));

        service.updateCompany(id, formData)
            .then(
                () => dispatch(success(formData)),
                errors => dispatch(failure(errors))
            );
    };

    function request(request) { return { type: constants.UPDATE_REQUEST, request } }
    function success(formData) { return { type: constants.UPDATE_SUCCESS, item: formData } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: constants.UPDATE_FAILURE, errors }
        }

        return { type: constants.UPDATE_FAILURE, errors: errors.errors }
    }
}

function deleteCompany(id) {
    return dispatch => {
        dispatch(request(id));

        service.deleteCompany(id)
            .then(
                () => {
                    dispatch(success(id));
                    dispatch(successAfterDelete(id));
                },
                errors => dispatch(failure(id, errors))
            );
    };

    function request(id) { return { type: constants.DELETE_REQUEST, id } }
    function success(id) { return { type: constants.DELETE_SUCCESS, id } }
    function successAfterDelete(id) { return { type: constants.UPDATE_AFTER_SUCCESS_DELETE, id } }
    function failure(id, error) { return { type: constants.DELETE_FAILURE, id, error } }
}

function clearAlerts() {
    return dispatch => {
        dispatch({type: constants.CLEAR_ALERTS});
    }
}
