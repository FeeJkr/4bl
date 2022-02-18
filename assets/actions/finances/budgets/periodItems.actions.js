import {periodItemsConstants as constants} from "../../../constants/finances/budgets/periodItems.constants";
import {periodItemsService as service} from "../../../services/finances/budgets/periodItems.service";

export const periodItemsActions = {
    getAll,
};

function getAll(periodId) {
    return dispatch => {
        dispatch(request());

        service.getAll(periodId)
            .then(
                items => dispatch(success(items)),
                errors => dispatch(failure(errors))
            );
    };

    function request() { return { type: constants.GET_ALL_REQUEST } }
    function success(items) { return { type: constants.GET_ALL_SUCCESS, items: items } }
    function failure(errors) { return { type: constants.GET_ALL_FAILURE, errors } }
}