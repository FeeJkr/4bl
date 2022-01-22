import {contractorsConstants as constants} from "../../../constants/invoices/contractors/constants";

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
        case constants.UPDATE_AFTER_SUCCESS_DELETE:
            return {
                items: state.items.filter(contractor => contractor.id !== action.id)
            };
        default:
            return state
    }
}
