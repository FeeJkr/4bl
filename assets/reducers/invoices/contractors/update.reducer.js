import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function update(state = {}, action) {
    switch (action.type) {
        case financesCategoriesConstants.UPDATE_REQUEST:
            return {
                isLoading: true,
            };
        case financesCategoriesConstants.UPDATE_SUCCESS:
            return {
                isUpdated: true,
            };
        case financesCategoriesConstants.UPDATE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesCategoriesConstants.UPDATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        case financesCategoriesConstants.CLEAR_ALERTS:
            return {
                ...state,
                isUpdated: false,
            };
        default:
            return state
    }
}