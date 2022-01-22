import {financesCategoriesConstants} from "../../../constants/finances.categories.constants";

export function one(state = {items: []}, action) {
    switch (action.type) {
        case financesCategoriesConstants.GET_ONE_REQUEST:
            return {};
        case financesCategoriesConstants.GET_ONE_SUCCESS:
            return {
                item: action.item,
            };
        case financesCategoriesConstants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesCategoriesConstants.GET_ONE_CHANGED:
            return {
                item: {...state.item, ...action.item},
            };
        default:
            return state
    }
}