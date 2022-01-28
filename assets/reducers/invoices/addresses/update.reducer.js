import {addressesConstants as constants} from "../../../constants/invoices/addresses/constants";

export function update(state = {}, action) {
    switch (action.type) {
        case constants.UPDATE_REQUEST:
            return {
                isLoading: true,
            };
        case constants.UPDATE_SUCCESS:
            return {
                isUpdated: true,
            };
        case constants.UPDATE_FAILURE:
            return {
                errors: action.errors,
            };
        case constants.UPDATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        case constants.CLEAR_ALERTS:
            return {
                ...state,
                isUpdated: false,
            };
        default:
            return state
    }
}