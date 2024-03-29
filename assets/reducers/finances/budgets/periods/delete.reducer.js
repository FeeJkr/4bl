import {periodsConstants as constants} from "../../../../constants/finances/budgets/periods.constants";

export function _delete(state = {items: []}, action) {
    switch (action.type) {
        case constants.DELETE_REQUEST:
            return {
                request: action.request
            };
        case constants.DELETE_SUCCESS:
            return {};
        case constants.DELETE_FAILURE:
            return {
                errors: action.errors,
            };
        default:
            return state
    }
}