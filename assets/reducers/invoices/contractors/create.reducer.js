import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function create(state = {items: []}, action) {
    switch (action.type) {
        case financesCategoriesConstants.CREATE_REQUEST:
            return {
                request: action.request,
                isLoading: true,
            };
        case financesCategoriesConstants.CREATE_SUCCESS:
            return {};
        case financesCategoriesConstants.CREATE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesCategoriesConstants.CREATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        default:
            return state
    }
}