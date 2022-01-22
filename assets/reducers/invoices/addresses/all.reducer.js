import {addressesConstants as constants} from "../../../constants/invoices/addresses/constants";

export function all(state = {items: []}, action) {
    switch (action.type) {
        case constants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case constants.GET_ALL_SUCCESS:
            return {
                items: action.items
            };
        case constants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };
        default:
            return state
    }
}
