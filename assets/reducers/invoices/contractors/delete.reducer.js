import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function _delete(state = {items: []}, action) {
    switch (action.type) {
        case financesCategoriesConstants.DELETE_REQUEST:
            return {
                request: action.request
            };
        case financesCategoriesConstants.DELETE_SUCCESS:
            return {};
        case financesCategoriesConstants.DELETE_FAILURE:
            return {
                errors: action.errors,
            };
        default:
            return state
    }
}