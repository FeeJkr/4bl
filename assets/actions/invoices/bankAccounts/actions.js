import {bankAccountsConstants as constants} from "../../../constants/invoices/bankAccounts/constants";
import {bankAccountsService as service} from "../../../services/invoices/bankAccounts/crud.service";

export const bankAccountsActions = {
    getAll,
    getOneById,
    createBankAccount,
    updateBankAccount,
    deleteBankAccount,
    clearAlerts,
};

function getAll(companyId) {
    return dispatch => {
        dispatch(request());

        service.getAll(companyId)
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

function createBankAccount(formData) {
    return dispatch => {
        dispatch(request(formData));

        service.createBankAccount(formData)
            .then(
                (response) => {
                    dispatch(success());

                    formData.id = response.data.id;

                    dispatch(updateAfterSuccess(formData));
                },
                errors => dispatch(failure(errors))
            );
    };

    function request(formData) { return { type: constants.CREATE_REQUEST, request: formData } }
    function success() { return { type: constants.CREATE_SUCCESS } }
    function updateAfterSuccess(bankAccount) { return { type: constants.UPDATE_AFTER_SUCCESS_CREATE, item: bankAccount } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: constants.CREATE_FAILURE, errors}
        }

        return { type: constants.CREATE_VALIDATION_FAILURE, errors: errors.errors}
    }
}

function updateBankAccount(id, formData, setOnEditMode) {
    return dispatch => {
        dispatch(request(formData));

        service.updateBankAccount(id, formData)
            .then(
                () => {
                    dispatch(success(formData));
                    setOnEditMode(false);
                },
                errors => dispatch(failure(errors))
            );
    };

    function request(request) { return { type: constants.UPDATE_REQUEST, request } }
    function success(formData) { return { type: constants.UPDATE_SUCCESS, item: formData } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: constants.UPDATE_FAILURE, errors }
        }

        return { type: constants.UPDATE_VALIDATION_FAILURE, errors: errors.errors }
    }
}

function deleteBankAccount(id, companyId) {
    return dispatch => {
        dispatch(request(id));

        service.deleteBankAccount(id, companyId)
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
