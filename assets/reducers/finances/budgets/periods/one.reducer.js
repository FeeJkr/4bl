import {periodsConstants as constants} from "../../../../constants/finances/budgets/periods.constants";

export function one(state = {item: {}}, action) {
    switch (action.type) {
        case constants.GET_ONE_REQUEST:
            return {};
        case constants.GET_ONE_SUCCESS:
            return {
                item: action.item,
            };
        case constants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };
        case constants.GET_ONE_CHANGED:
            return {
                item: {...state.item, ...action.item},
            };
        default:
            return state
    }
}