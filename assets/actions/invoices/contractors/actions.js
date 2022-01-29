import {contractorsConstants} from "../../../constants/invoices/contractors/constants";
import {contractorsService} from "../../../services/invoices/contractors/crud.service";

export const contractorsActions = {
    getAll,
    getOneById,
    createContractor,
    updateContractor,
    deleteContractor,
    clearAlerts,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        contractorsService.getAll()
            .then(
                contractors => dispatch(success(contractors)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: contractorsConstants.GET_ALL_REQUEST } }
    function success(contractors) { return { type: contractorsConstants.GET_ALL_SUCCESS, items: contractors } }
    function failure(errors) { return { type: contractorsConstants.GET_ALL_FAILURE, errors } }
}

function getOneById(id) {
    return dispatch => {
        dispatch(request());

        contractorsService.getOneById(id)
            .then(
                contractor => {
                    dispatch(success(contractor));
                },
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: contractorsConstants.GET_ONE_REQUEST } }
    function success(contractor) { return { type: contractorsConstants.GET_ONE_SUCCESS, item: contractor } }
    function failure(errors) { return { type: contractorsConstants.GET_ONE_FAILURE, errors } }
}

function createContractor(formData, navigate) {
    return dispatch => {
        dispatch(request(formData));

        contractorsService.createContractor(formData)
            .then(
                () => {
                    dispatch(success());
                    navigate('/invoices/contractors');
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: contractorsConstants.CREATE_REQUEST, request: formData } }
    function success() { return { type: contractorsConstants.CREATE_SUCCESS } }
    function failure(errors, company) {
        if (errors.type === 'DomainError') {
            return { type: contractorsConstants.CREATE_FAILURE, errors, company }
        }

        return { type: contractorsConstants.CREATE_VALIDATION_FAILURE, errors: errors.errors, company, }
    }
}

function updateContractor(id, formData) {
    return dispatch => {
        dispatch(request(formData));

        contractorsService.updateContractor(id, formData)
            .then(
                () => dispatch(success(formData)),
                errors => dispatch(failure(errors))
            );
    };

    function request(request) { return { type: contractorsConstants.UPDATE_REQUEST, request } }
    function success(formData) { return { type: contractorsConstants.UPDATE_SUCCESS, item: formData } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: contractorsConstants.UPDATE_FAILURE, errors }
        }

        return { type: contractorsConstants.UPDATE_FAILURE, errors: errors.errors }
    }
}

function deleteContractor(id) {
    return dispatch => {
        dispatch(request(id));

        contractorsService.deleteContractor(id)
            .then(
                () => {
                    dispatch(success(id));
                    dispatch(successAfterDelete(id));
                },
                errors => dispatch(failure(id, errors))
            );
    };

    function request(id) { return { type: contractorsConstants.DELETE_REQUEST, id } }
    function success(id) { return { type: contractorsConstants.DELETE_SUCCESS, id } }
    function successAfterDelete(id) { return { type: contractorsConstants.UPDATE_AFTER_SUCCESS_DELETE, id } }
    function failure(id, error) { return { type: contractorsConstants.DELETE_FAILURE, id, error } }
}

function clearAlerts() {
    return dispatch => {
        dispatch({type: contractorsConstants.CLEAR_ALERTS});
    }
}
