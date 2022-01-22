import {addressesService} from "../../../services/invoices/addresses/crud.service";
import {addressesConstants} from "../../../constants/invoices/addresses/constants";

export const addressesActions = {
    getAll,
    getOneById,
};

function getAll() {
    return dispatch => {
        dispatch(request());

        addressesService.getAll()
            .then(
                items => dispatch(success(items)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: addressesConstants.GET_ALL_REQUEST } }
    function success(contractors) { return { type: addressesConstants.GET_ALL_SUCCESS, items: contractors } }
    function failure(errors) { return { type: addressesConstants.GET_ALL_FAILURE, errors } }
}

function getOneById(id) {
    return dispatch => {
        dispatch(request());

        addressesService.getOneById(id)
            .then(
                contractor => dispatch(success(contractor)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: addressesConstants.GET_ONE_REQUEST } }
    function success(contractor) { return { type: addressesConstants.GET_ONE_SUCCESS, item: contractor } }
    function failure(errors) { return { type: addressesConstants.GET_ONE_FAILURE, errors } }
}
