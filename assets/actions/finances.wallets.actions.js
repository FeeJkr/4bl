import {history} from "../helpers/history";
import {financesWalletsService} from "../services/finances.wallets.service";
import {financesWalletsConstants} from "../constants/finances.wallets.constants";

export const financesCategoriesActions = {
    createWallet,
    updateWallet,
    deleteWallet,
    getAll,
    getOne,
    change,
    clearAlerts,
};

function createWallet(formData) {
    return dispatch => {
        dispatch(request(formData));

        financesWalletsService.createWallet(formData)
            .then(
                response => {
                    dispatch(success());
                    history.push('/finances/wallets');
                },
                errors => dispatch(failure(errors, formData))
            );
    };

    function request(formData) { return { type: financesWalletsConstants.CREATE_REQUEST, request: formData } }
    function success() { return { type: financesWalletsConstants.CREATE_SUCCESS } }
    function failure(errors, category) {
        if (errors.type === 'DomainError') {
            return { type: financesWalletsConstants.CREATE_FAILURE, errors, category }
        }

        return { type: financesWalletsConstants.CREATE_VALIDATION_FAILURE, errors: errors.errors, category, }
    }
}

function updateWallet(id, wallet) {
    return dispatch => {
        dispatch(request());

        financesWalletsService.updateWallet(id, wallet)
            .then(
                response => {
                    dispatch(success());
                },
                errors => dispatch(failure(errors, wallet))
            );
    };

    function request() { return { type: financesWalletsConstants.UPDATE_REQUEST, isLoading: true } }
    function success() { return { type: financesWalletsConstants.UPDATE_SUCCESS, isUpdated: true } }
    function failure(errors, wallet) {
        if (errors.type === 'DomainError') {
            return { type: financesWalletsConstants.UPDATE_FAILURE, errors, wallet}
        }

        return { type: financesWalletsConstants.UPDATE_VALIDATION_FAILURE, errors: errors.errors, wallet}
    }
}

function deleteWallet(id) {
    return dispatch => {
        dispatch(request(id));

        financesWalletsService.deleteWallet(id)
            .then(
                response => {
                    dispatch(success());
                    dispatch(updateWalletsList(id));
                },
                errors => dispatch(failure(errors))
            );

        function request(id) { return {type: financesWalletsConstants.DELETE_REQUEST, id} }
        function success() { return {type: financesWalletsConstants.DELETE_SUCCESS} }
        function failure(errors) { return {type:financesWalletsConstants.DELETE_FAILURE, errors} }
        function updateWalletsList(id) { return {type: financesWalletsConstants.UPDATE_AFTER_SUCCESS_DELETE, id } }
    }
}

function getAll() {
    return dispatch => {
        dispatch(request());

        financesWalletsService.getAll()
            .then(
                items => dispatch(success(items)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: financesWalletsConstants.GET_ALL_REQUEST } }
    function success(items) { return { type: financesWalletsConstants.GET_ALL_SUCCESS, items } }
    function failure(errors) { return { type: financesWalletsConstants.GET_ALL_FAILURE, errors } }
}

function getOne(id) {
    return dispatch => {
        dispatch(request());

        financesWalletsService.getOne(id)
            .then(
                item => dispatch(success(item)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: financesWalletsConstants.GET_ONE_REQUEST } }
    function success(item) { return { type: financesWalletsConstants.GET_ONE_SUCCESS, item } }
    function failure(errors) { return { type: financesWalletsConstants.GET_ONE_FAILURE, errors } }
}

function change(item) {
    return dispatch => {
        dispatch(change(item))

        function change(item) { return { type: financesWalletsConstants.GET_ONE_CHANGED, item} }
    }
}

function clearAlerts() {
    return dispatch => {dispatch({type: financesWalletsConstants.CLEAR_ALERTS})};
}
