import {documentsConstants as constants} from "../../../constants/invoices/documents/constants";

export const documentsActions = {
    getAll,
    getOneById,
    createDocument,
    updateDocument,
    deleteDocument,
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

    function request() { return { type: constants.GET_ALL_REQUEST } }
    function success(contractors) { return { type: constants.GET_ALL_SUCCESS, items: contractors } }
    function failure(errors) { return { type: constants.GET_ALL_FAILURE, errors } }
}

function getOneById(id) {
    return dispatch => {
        dispatch(request());

        contractorsService.getOneById(id)
            .then(
                contractor => {
                    dispatch(success(contractor));
                    dispatch(addressesActions.getOneById(contractor.addressId));
                },
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: constants.GET_ONE_REQUEST } }
    function success(contractor) { return { type: constants.GET_ONE_SUCCESS, item: contractor } }
    function failure(errors) { return { type: constants.GET_ONE_FAILURE, errors } }
}

function createDocument(formData, navigate) {
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

    function request(formData) { return { type: constants.CREATE_REQUEST, request: formData } }
    function success() { return { type: constants.CREATE_SUCCESS } }
    function failure(errors, company) {
        if (errors.type === 'DomainError') {
            return { type: constants.CREATE_FAILURE, errors, company }
        }

        return { type: constants.CREATE_VALIDATION_FAILURE, errors: errors.errors, company, }
    }
}

function updateDocument(id, formData) {
    return dispatch => {
        dispatch(request(formData));

        contractorsService.updateContractor(id, formData)
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

function deleteDocument(id) {
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
